<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    //protected $with = [
    //    'product',
    //]

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function pembeli()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }
}
