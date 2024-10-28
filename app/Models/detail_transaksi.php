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
        'id_transaksi','id_menu','harga'];
}
