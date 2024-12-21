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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
            Log::info('request: ', $request->all());
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // Ambil data order berdasarkan ID
            $order = Order::with('orderItems.productVariant.product', 'orderItems.productVariant.variant')->findOrFail($request->order_id);
            $grossAmount = $order->price + $order->shipping_cost;

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->phone_number,
                    'address' => $order->shipping_address,
                ],
                'shipping_details' => [
                    'first_name' => $order->shipping_method,
                    'address' => $order->shipping_address,
                    "country_code" => "IDN"
                ],
                'item_details' => array_merge(
                    $order->orderItems->map(function ($item) {
                        return [
                            'id' => $item->product_id,
                            'price' => $item->productVariant->price,
                            'quantity' => $item->quantity,
                            'name' => $item->productVariant->product->name,
                        ];
                    })->toArray(),
                    [
                        [
                            'id' => 'shipping_cost',
                            'price' => $order->shipping_cost,
                            'quantity' => 1,
                            'name' => 'Shipping Cost',
                        ],
                    ]
                ),
            ];
            // \Log::info('Transaction Details: ', $params);
            // Buat token pembayaran
            $snapToken = Snap::getSnapToken($params);

            if (!$snapToken) {
                throw new \Exception('Snap token generation failed.');
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

                    foreach ($order->orderItems as $item) {
                        // $product = Product::find($item->product_id);
                        // $product = Product::where('id', $item->product_id)
                        //     ->lockForUpdate()
                        //     ->first();
                        // if ($product) {
                        //     $product->stock -= $item->quantity;
                        //     $product->save();
                        $productVariant = ProductVariant::where('id', $item->product_variant_id)
                            ->lockForUpdate()->first();

                        if ($productVariant) {
                            // Kurangi stok di ProductVariant
                            $productVariant->stock -= $item->quantity;
                            if ($productVariant->stock < 0) {
                                DB::rollBack();
                                Log::error("Stok produk tidak cukup untuk order {$orderId}.");
                                Toaster::error("Stok produk tidak mencukupi");
                                return response()->json(['message' => 'Stok tidak cukup'], 400);
                                // throw new \Exception("Stok produk '{$product->name}' tidak cukup untuk memenuhi pesanan.");
                            }
                            $productVariant->save();
                        }
                    }

                    Payment::create([
                        'order_id' => $orderId,
                        'transaction_id' => $transactionId,
                        'status' => 'success',
                        'payment_type' => $type,
                        'transaction_time' => $transactionTime,
                        'bank' => $bank,
                        'gross_amount' => $grossAmount,
                        'midtrans_status' => $transaction,
                        'json_response' => json_encode($notif),
                    ]);

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
