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
        Schema::create('rekam_spt', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_bukti_penyetoran',['surat setoran pajak','pemindahbukuan']);
            $table->string('npwp');
            $table->string('ntpn');
            $table->string('nomor_pemindahbukuan')->nullable();
            $table->string('tahun_pajak');
            $table->string('masa_pajak');
            $table->string('jenis_pajak');
            $table->string('jenis_setoran');
            $table->string('jumlah_setor');
            $table->string('tanggal_setor');
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
        Schema::dropIfExists('rekam_spt');
    }
};
