<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'id_karyawan');
    }
}
