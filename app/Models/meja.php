<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meja extends Model
{
    use HasFactory;
    protected $table = 'mejas';
    protected $primaryKey = 'id_meja';
    public $timestamps = false;
    public $fillable = [
        'nomor_meja','status'];
}
