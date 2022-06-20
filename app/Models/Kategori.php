<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $guarded = ['id_kategori'];
    protected $primaryKey = 'id_kategori';
    protected $table = 'kategori';

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
