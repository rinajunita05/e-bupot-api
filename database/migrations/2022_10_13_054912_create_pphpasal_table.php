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
        Schema::create('pphpasal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaturan_id')->nullable()->constrained('pengaturan');
            $table->string('tahun_pajak');
            $table->string('masa_pajak');
            $table->string('nama');
            $table->enum('identitas',['npwp','nik']);
            $table->string('no_identitas');
            $table->string('qq')->nullable();
            $table->string('kode_objek_pajak');
            $table->enum('fasilitas_pajak_penghasilan',['tanpa fasilitas','surat keterangan bebas','pph ditanggung pemerintah','surat keterangan berdasarkan pp no 23 2018','fasilitas lainnya berdasarkan']);
            $table->string('no_fasilitas')->nullable();
            $table->string('jumlah_penghasilan_bruto');
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
        Schema::dropIfExists('pphpasal');
    }
};
