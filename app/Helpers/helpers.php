<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('formatImageUrl')) {
    function formatImageUrl($image)
    {
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        return Storage::url($image);
    }
}

if (!function_exists('orderStatus')) {
    function orderStatus(string $status): string
    {
        $translations = [
            'pending'    => 'Tertunda',
            'paid'       => 'Dibayar',
            'processed'  => 'Diproses',
            'shipped'    => 'Dikirim',
            'delivered'  => 'Diterima',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
        ];

        return $translations[$status] ?? $status;
    }
}

if (!function_exists('orderStatusClass')) {
    function orderStatusClass(string $status): string
    {
        $classes = [
            'pending'    => 'text-yellow-500 bg-yellow-50',
            'paid'       => 'text-purple-500 bg-purple-50',
            'processed'  => 'text-slate-50 bg-slate-950',
            'shipped'    => 'text-cyan-400 bg-cyan-50',
            'delivered'  => 'text-blue-600 bg-blue-50',
            'completed'  => 'text-green-500 bg-green-50',
            'cancelled'  => 'text-red-500 bg-red-50',
        ];

        return $classes[$status] ?? 'text-slate-500 bg-slate-50';
    }
}
