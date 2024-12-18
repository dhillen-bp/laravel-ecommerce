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
