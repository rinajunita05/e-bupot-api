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
        Schema::create('objek_pajak', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pajak');
            $table->string('nama_pajak');
            $table->string('persen');
            $table->string('netto')->nullable();
            $table->enum('jenis',['non_residen','pasal']);
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
        Schema::dropIfExists('objek_pajak');
    }
};
