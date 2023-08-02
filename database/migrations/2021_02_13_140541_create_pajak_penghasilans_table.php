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
        Schema::create('pajak_penghasilan', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_bukti_penyetoran',['surat setoran pajak','pemindahbukuan'])->nullable();
            $table->string('ntpn')->nullable();
            $table->string('nomor_bukti')->nullable();
            $table->string('nomor_pemindahbukuan')->nullable();
            $table->string('masa_pajak')->nullable();
            $table->string('jenis_pajak')->nullable();
            $table->string('jenis_setoran')->nullable();
            $table->string('kode_objek_pajak')->nullable();
            $table->string('jumlah_penghasilan_bruto')->nullable();
            $table->string('jumlah_setor')->nullable();
            $table->string('tanggal_setor')->nullable();
            $table->foreignId('pengaturan_id')->nullable()->constrained('pengaturan');
            $table->string('tahun_pajak')->nullable();
            $table->string('nama')->nullable();
            $table->enum('identitas',['npwp','nik'])->nullable();
            $table->string('no_identitas')->nullable();
            $table->string('qq')->nullable();
            $table->enum('fasilitas_pajak_penghasilan',['tanpa fasilitas','surat keterangan bebas','skd wpln','pph ditanggung pemerintah','surat keterangan berdasarkan pp no 23 2018','fasilitas lainnya berdasarkan'])->nullable();
            $table->string('no_fasilitas')->nullable();
            $table->enum('kelebihan_pemotongan',['pengembalian','pemindahbukuan'])->nullable();
            $table->string('status')->nullable();
            $table->string('tin')->nullable();
            $table->string('alamat')->nullable();
            $table->string('negara')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tgl_lahir')->nullable();
            $table->string('no_paspor')->nullable();
            $table->string('no_kitas')->nullable();
            $table->string('netto')->nullable();
            $table->string('tarif')->nullable();
            $table->string('no_bukti')->nullable();
            $table->string('pernyataan')->nullable();
            $table->boolean('is_posted')->default(0);
            $table->enum('tipe',['pphsendiri','pphpasal','pphnon','importdata'])->nullable();
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
        Schema::dropIfExists('pajak_penghasilans');
    }
};
