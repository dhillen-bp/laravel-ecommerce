<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Masmerise\Toaster\Toaster;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // Ambil data order berdasarkan ID
            $order = Order::findOrFail($request->order_id);
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
                'item_details' => $order->orderItems->map(function ($item) {
                    return [
                        'id' => $item->product_id,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'name' => $item->product->name,
                    ];
                })->toArray(),
            ];

            // Buat token pembayaran
            $snapToken = Snap::getSnapToken($params);

            if (!$snapToken) {
                throw new \Exception('Snap token generation failed.');
            }

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            // Tangkap error dan kembalikan pesan kesalahan
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(), // Bisa digunakan untuk debug
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
            $statusCode = $notif->status_code;
            $transactionId = $notif->transaction_id;

            DB::beginTransaction();
            // Proses berdasarkan status transaksi
            if ($transaction == 'capture' || $transaction == 'settlement') {
                // Simpan data pembayaran ke database
                $order = Order::where('id', $orderId)->first();

                if ($order) {
                    foreach ($order->orderItems as $item) {
                        $product = Product::find($item->product_id);
                        if ($product) {
                            $product->stock -= $item->quantity;
                            $product->save();
                        }
                    }

                    Payment::create([
                        'order_id' => $orderId,
                        'transaction_id' => $transactionId,
                        'status' => 'success',
                        'payment_type' => $type,
                        'transaction_time' => $transactionTime,
                        'status_code' => $statusCode,
                        'gross_amount' => $grossAmount,
                        'midtrans_status' => $transaction,
                        'json_response' => json_encode($notif), // Menyimpan respon lengkap untuk debug
                    ]);
                }
            } else if ($transaction == 'pending') {
                Payment::create([
                    'order_id' => $orderId,
                    'transaction_id' => $transactionId,
                    'status' => 'pending',
                    'payment_type' => $type,
                    'transaction_time' => $transactionTime,
                    'status_code' => $statusCode,
                    'gross_amount' => $grossAmount,
                    'midtrans_status' => $transaction,
                ]);
            } else {
                Payment::create([
                    'order_id' => $orderId,
                    'transaction_id' => $transactionId,
                    'status' => 'failed',
                    'payment_type' => $type,
                    'transaction_time' => $transactionTime,
                    'status_code' => $statusCode,
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
}
