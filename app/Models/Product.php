<?php

namespace App\Models;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['nama_produk', 'harga_produk', 'stok_produk', 'id_sales'];

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'id_sales');
    }
}
