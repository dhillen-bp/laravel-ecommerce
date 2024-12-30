<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;
use Filament\Notifications\Notification as FilamentNotification;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
            // Log::info('request: ', $request->all());
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // Ambil data order berdasarkan ID
            $order = Order::with('order_items.product_variant.product', 'order_items.product_variant.variant')->findOrFail($request->order_id);

            // Log::info('All Items Prices = ', $order->order_items->map(function ($item) {
            //     return $item->product_variant->price;
            // })->toArray());

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_order_price,
                ],
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone_number,
                    'address' => $order->user->address,
                ],
                'shipping_details' => [
                    'first_name' => $order->user->courier_name,
                    'address' => $order->user->address,
                    "country_code" => "IDN"
                ],
                'item_details' => array_merge(
                    $order->order_items->map(function ($item) {
                        return [
                            'id' => $item->product_variant->product->id,
                            'price' => $item->product_variant->price,
                            'quantity' => $item->quantity,
                            'brand' => $item->product_variant->product->name,
                            'name' => $item->product_variant->variant->name,
                            'merchant_name' => "Laravel Olsop",
                            'category' => $item->product_variant->product->category->name,
                        ];
                    })->toArray(),
                    [
                        [
                            'id' => 'shipping_cost',
                            'price' => $order->shipping->cost,
                            'quantity' => 1,
                            'name' => 'Shipping Cost',
                        ],
                    ]
                ),
            ];
            // Log::info('Transaction Details: ', $params);

            // Buat token pembayaran
            $snapToken = Snap::getSnapToken($params);

            if (!$snapToken) {
                throw new \Exception('Snap token generation failed.');
            }

            // Log::info("snap: " . $snapToken);

            $existingPayment = Payment::where('snap_token', $snapToken)->first();
            $existingPayment2 = Payment::where('order_id', $order->id)->first();
            if ($existingPayment || $existingPayment2) {
                Toaster::error('Payment sudah dilakukan sebelumnya.');
                return redirect()->route('front.order');
            } else {
                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'snap_token' => $snapToken,
                        'status' => 'pending',
                    ]
                );
            }

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Error Occurred: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function paymentCallback(Request $request)
    {
        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            $notif = new \Midtrans\Notification();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $grossAmount = $notif->gross_amount;
            $transactionTime = $notif->transaction_time;
            $bank = $notif->bank;
            $transactionId = $notif->transaction_id;

            DB::beginTransaction();
            // Proses berdasarkan status transaksi
            if ($transaction == 'capture' || $transaction == 'settlement') {
                // Simpan data pembayaran ke database
                $order = Order::where('id', $orderId)->first();

                if ($order) {
                    $order->status = 'paid';
                    $order->save();

                    foreach ($order->order_items as $item) {
                        // $product = Product::find($item->product_id);
                        // $product = Product::where('id', $item->product_id)
                        //     ->lockForUpdate()
                        //     ->first();
                        // if ($product) {
                        //     $product->stock -= $item->quantity;
                        //     $product->save();
                        $product_variant = ProductVariant::where('id', $item->product_variant_id)
                            ->lockForUpdate()->first();

                        if ($product_variant) {
                            // Kurangi stok di ProductVariant
                            $product_variant->stock -= $item->quantity;
                            if ($product_variant->stock < 0) {
                                DB::rollBack();
                                Log::error("Stok produk tidak cukup untuk order {$orderId}.");
                                Toaster::error("Stok produk tidak mencukupi");
                                return response()->json(['message' => 'Stok tidak cukup'], 400);
                                // throw new \Exception("Stok produk '{$product->name}' tidak cukup untuk memenuhi pesanan.");
                            }
                            $product_variant->save();
                        }
                    }

                    Payment::updateOrCreate(['order_id' => $orderId,], [
                        'transaction_id' => $transactionId,
                        'status' => 'success',
                        'payment_type' => $type,
                        'transaction_time' => $transactionTime,
                        'bank' => $bank,
                        'gross_amount' => $grossAmount,
                        'midtrans_status' => $transaction,
                        'json_response' => json_encode($notif),
                    ]);

                    $recipient = $order->user;
                    // $notify = $recipient->notify(
                    //     FilamentNotification::make()
                    //         ->title('Pesanan Berhasil')
                    //         ->body("Pesanan dengan Order ID = {$order->id} oleh Pengguna dengan nama {$recipient->name} dan email {$recipient->email} berhasil dibuat. Status pesanan saat ini adalah {$order->status}")
                    //         ->toDatabase()
                    // );
                    $owners = User::role('owner')->get();
                    foreach ($owners as $owner) {
                        $owner->notify(
                            FilamentNotification::make()
                                ->title('Pesanan Berhasil Dibuat')
                                ->body("
                                <div class=''>
                                    <p class='font-bold text-green-500'>Pesanan Berhasil</p>
                                    <p>Order ID: <span class='text-purple-500 font-semibold'>{$order->id}</span></p>
                                    <p>Nama: <span class='text-gray-700'>{$recipient->name}</span></p>
                                    <p>Email: <span class='text-gray-700'>{$recipient->email}</span></p>
                                    <p>Order Status: <span class='bg-purple-50 text-purple-500 text-xs font-medium mr-2 px-1.5 py-1 rounded-full'>{$order->status}</span></p>
                                    <a href='/admin/orders/$order->id' class='bg-purple-500 text-white text-xs font-medium mt-2 px-2 py-1.5 rounded-full'>Lihat Detail</a>
                                    </div>
                                ")
                                ->toDatabase()
                        );
                    }

                    Log::info('recipient: ' . $recipient);
                    // Log::info('notify: ' . $notify);

                    Toaster::success('Pembayaran berhasil dilakukan!');
                }
            } else if ($transaction == 'pending') {
                Payment::create([
                    'order_id' => $orderId,
                    'transaction_id' => $transactionId,
                    'status' => 'pending',
                    'payment_type' => $type,
                    'transaction_time' => $transactionTime,
                    'bank' => $bank,
                    'gross_amount' => $grossAmount,
                    'midtrans_status' => $transaction,
                ]);
            } else {
                Payment::create([
                    'order_id' => $orderId,
                    'transaction_id' => $transactionId,
                    'status' => 'cancelled',
                    'payment_type' => $type,
                    'transaction_time' => $transactionTime,
                    'bank' => $bank,
                    'gross_amount' => $grossAmount,
                    'midtrans_status' => $transaction,
                ]);
            }
            DB::commit();
            // Respon ke Midtrans

            return response()->json(['message' => 'Notification successfully processed'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to process notification'], 500);
        }
    }

    public function paymentFailed(Order $order)
    {
        $order->update(['status' => 'cancelled']);
    }

    public function paymentFailedMessage()
    {
        Toaster::error("Gagal melakukan pembayaran!");

        return redirect()->route('front.order');
    }
}
