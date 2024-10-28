<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksiZ';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $fillable = [
        'id_transaksi',
        'id_menu',
        'harga'
    ];

    public function transaksi()
    {
        return $this->belongsTo(transaksi::class, 'id_transaksi', 'id_transaksi');
    }
    public function menu()
    {
        return $this->belongsTo(menu::class, 'id_menu', 'id_menu');
    }
}
