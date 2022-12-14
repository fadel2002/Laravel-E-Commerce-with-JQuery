<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_barang';
    
    protected $fillable = [
        'nama_barang',
        'deskripsi_barang',
        'nama_kategori',
        'stok_barang',
        'harga_barang',
        'gambar_barang',
        'berat_barang',
    ];

    public function gambarBarangs(){
        return $this->hasMany(GambarBarang::class, 'id_barang');
    }  

    public function detailTransaksi(){
        return $this->belongsTo(DetailTransaksi::class, 'id_barang');
    } 
}