<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPermintaan extends Model
{
    use HasFactory;

    protected $fillable = [ 'id_permintaan', 'id_produk', 'jumlah_permintaan', 'jumlah_diterima', 'pesan', 'status'];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'id_permintaan');
    }
}
