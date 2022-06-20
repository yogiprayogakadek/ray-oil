<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $guarded = ['id_transaksi'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function detail_transaksi()
    {
        return $this->hasMany('App\Models\DetailTransaksi', 'id_transaksi');
    }
    
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_penyewaan');
    }
}
