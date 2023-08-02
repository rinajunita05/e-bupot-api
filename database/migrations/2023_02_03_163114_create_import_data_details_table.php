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
        Schema::create('import_data_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_data_id');
            $table->foreign('import_data_id')->references('id')->on('import_data')->onDelete('cascade')->nullable();
            $table->string("tgl_pemotongan")->nullable();
            $table->string("penerima_penghasilan")->nullable();
            $table->string("npwp")->nullable();
            $table->string("nik")->nullable();
            $table->string("nama_penerima")->nullable();
            $table->string("qq")->nullable();
            $table->string("no_hp")->nullable();
            $table->string("kode_objek_pajak")->nullable();
            $table->string("penandatangan_bp")->nullable();
            $table->string("penandatangan_menggunakan")->nullable();
            $table->string("npwp_penandatangan")->nullable();
            $table->string("nik_penandatangan")->nullable();
            $table->string("namapenandatangan_sesuai_nik")->nullable();
            $table->string("penghasilan_bruto")->nullable();
            $table->string("fasilitas")->nullable();
            $table->string("no_skb")->nullable();
            $table->string("no_aturandtp")->nullable();
            $table->string("no_suketpp23")->nullable();
            $table->string("fasilitaspph_berfaspph_lainnya")->nullable();
            $table->string("lb_diproses")->nullable();
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
        Schema::dropIfExists('import_data_details');
    }
};
