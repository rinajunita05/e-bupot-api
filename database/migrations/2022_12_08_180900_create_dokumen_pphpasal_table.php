<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen_pphpasal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pajak_penghasilan_id')->nullable();
            $table->foreign('pajak_penghasilan_id')->references('id')->on('pajak_penghasilan')->cascadeOnDelete();
            $table->string('nama_dokumen');
            $table->string('no_dokumen');
            $table->string('tgl_dokumen');
            // $table->foreignId('pajak_penghasilan_id')->nullable()->constrained('pajak_penghasilan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen_pphpasal');
    }
};
