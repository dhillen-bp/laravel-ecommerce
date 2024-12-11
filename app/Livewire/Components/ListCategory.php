<?php

namespace App\Livewire\Components;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ListCategory extends Component
{
    public function render()
    {
        $categories = Cache::remember('categories', now()->addMinutes(30), function () {
            return Category::all();
        });

        return view('livewire.components.list-category', compact('categories'));
    }
}
