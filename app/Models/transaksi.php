<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;
    public $fillable = [
        'tgl_transaksi','id_user','id_meja','nama_pelanggan','status'];

        public function userRelations()
        {
            return $this->belongsTo(User::class, 'id_user', 'id_user');
        }
    
        public function mejaRelations()
        {
            return $this->belongsTo(meja::class, 'id_meja', 'id_meja');
        }
        public function detailTransaksiRelations()
        {
            return $this->hasMany(detail_transaksi::class, 'id_transaksi', 'id_transaksi');
        }
}



