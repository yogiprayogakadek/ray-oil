<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = ['id_produk'];
    protected $primaryKey = 'id_produk';
    protected $table = 'produk';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function detail_transaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk');
    }
}
