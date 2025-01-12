<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewFileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4|max:2048', // Sesuaikan validasi
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public'); // Menyimpan file di storage/public/uploads

            return response()->json([
                'success' => true,
                'path' => Storage::url($path), // Mengembalikan URL file
            ]);
        }

        return response()->json(['success' => false], 400);
    }
}
