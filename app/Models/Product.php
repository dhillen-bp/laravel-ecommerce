<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'slug', 'image', 'is_active', 'category_id'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function variants()
    // {
    //     return $this->belongsToMany(Variant::class, 'product_variants');
    // }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'product_variants')
            ->withPivot('id', 'price', 'stock')
            ->withTimestamps();
    }
}
