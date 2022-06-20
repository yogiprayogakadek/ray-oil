<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail_transaksi';
    protected $guarded = ['id_detail_transaksi'];

    public function transaksi()
    {
        return $this->belongsTo('App\Models\Transaksi', 'id_transaksi');
    }

    public function produk()
    {
        return $this->belongsTo('App\Models\Produk', 'id_produk');
    }
}
