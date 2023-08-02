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
        Schema::create('pphsendiri', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_bukti_penyetoran',['surat setoran pajak','pemindahbukuan']);
            $table->string('ntpn');
            $table->string('nomor_bukti');
            $table->string('nomor_pemindahbukuan')->nullable();
            $table->string('tahun_pajak');
            $table->string('masa_pajak');
            $table->string('jenis_pajak');
            $table->string('jenis_setoran');
            $table->string('kode_objek_pajak');
            $table->string('jumlah_penghasilan_bruto');
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
        Schema::dropIfExists('pphsendiri');
    }
};
