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

        Schema::create('penilaian_prodi',function(Blueprint $table){
            $table->id();
            $table->char('penilaian_kode',30);
            $table->date('penilaian_tgl');
            $table->unsignedBigInteger('penilaian_idprodi');
            $table->unsignedBigInteger('penilaian_iddetailkategori');
            $table->unsignedBigInteger('penilaian_idbobot');
            $table->timestamps();

            $table->foreign('penilaian_idprodi')->references('id')->on('prodi');
            $table->foreign('penilaian_iddetailkategori')->references('id')->on('detail_kategori');
            $table->foreign('penilaian_idbobot')->references('id')->on('bobot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_prodi');
    }
};
