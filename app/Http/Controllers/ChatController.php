<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Chatify\Facades\ChatifyMessenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index($id = null, $product_id = null)
    {

        $product = Product::find($product_id);

        // Jika produk tidak ditemukan, set $product menjadi null
        if (!$product) {
            $product = null;
        }

        // Ambil warna messenger pengguna
        $messenger_color = Auth::user()->messenger_color;

        // Kirimkan data ke view
        return view('Chatify::pages.app', [
            'id' => $id ?? 0,
            'messengerColor' => $messenger_color ? $messenger_color : ChatifyMessenger::getFallbackColor(),
            'dark_mode' => Auth::user()->dark_mode < 1 ? 'light' : 'dark',
            'product' => $product,  // Kirimkan product ke view
        ]);
    }
}
