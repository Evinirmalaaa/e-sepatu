<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = [
        'user',
        'product'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}