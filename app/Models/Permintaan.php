<?php

namespace App\Models;

use App\Models\DetailPermintaan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaans';

    protected $fillable = ['tanggal_permintaan', 'id_staff_gudang', 'status', 'id_staff_proyek', 'catatan'];

    public function staff_gudang()
    {
        return $this->belongsTo(User::class, 'id_staff_gudang');
    }

    public function staff_proyek()
    {
        return $this->belongsTo(User::class, 'id_staff_proyek');
    }

    public function detailPermintaan()
    {
        return $this->hasMany(DetailPermintaan::class, 'id_permintaan');
    }
}
