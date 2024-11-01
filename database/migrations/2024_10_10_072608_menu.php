<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->String('nama_menu');
            $table->enum ('jenis',['makanan','minuman']);
            $table->String('deskripsi');
            $table->String('gambar');
            $table->double('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
