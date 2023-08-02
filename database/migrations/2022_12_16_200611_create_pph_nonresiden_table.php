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
        Schema::create('pph_nonresiden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaturan_id')->nullable()->constrained('pengaturan');
            $table->string('tahun_pajak');
            $table->string('masa_pajak');
            $table->string('tin');
            $table->string('nama');
            $table->string('alamat');
            $table->string('negara');
            $table->string('tempat_lahir');
            $table->string('tgl_lahir');
            $table->string('no_paspor');
            $table->string('no_kitas');
            $table->string('kode_objek_pajak');
            $table->enum('fasilitas_pajak_penghasilan',['tanpa fasilitas','skd wpln','pph ditanggung pemerintah', 'fasilitas lainnya berdasarkan']);
            $table->string('no_fasilitas')->nullable();
            $table->string('jumlah_penghasilan_bruto');
            $table->string('netto')->nullable();
            $table->string('tarif');
            $table->string('jumlah_setor');
            $table->string('no_bukti');
            $table->enum('kelebihan_pemotongan',['pengembalian','pemindahbukuan']);
            $table->string('status');
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
        Schema::dropIfExists('pph_nonresiden');
    }
};
