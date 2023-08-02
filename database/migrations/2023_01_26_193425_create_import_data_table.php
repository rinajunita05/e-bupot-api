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
        Schema::create('import_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');
            $table->enum('status',['ya','tidak'])->default('ya');
            $table->string('ket_up');
            $table->foreignId('pajak_penghasilan_id')->nullable()->constrained('pajak_penghasilan');
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
        Schema::dropIfExists('import_data');
    }
};
