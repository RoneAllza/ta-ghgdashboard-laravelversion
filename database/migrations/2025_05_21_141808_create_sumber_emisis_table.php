<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sumber_emisis', function (Blueprint $table) {
            $table->id();
            $table->string('sumber')->nullable();
            $table->string('tipe_sumber')->nullable();
            $table->float('kapasitas_output')->nullable();
            $table->float('durasi_pemakaian');
            $table->enum('category_code', ['1A1', '1A2', '1B1']);
            $table->integer('frekuensi_hari');
            $table->enum('unit', ['ton', 'liter'])->default('ton');
            $table->json('emission_factors')->default(new Expression('(JSON_ARRAY())'));
            $table->unsignedBigInteger('fuel_properties_id')->default(0);
            $table->unsignedBigInteger('kategori_sumber_id')->default(0);
            $table->foreign('fuel_properties_id')->references('id')->on('fuel_properties')->onDelete('cascade');
            $table->foreign('kategori_sumber_id')->references('id')->on('kategori_sumbers')->onDelete('cascade');
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sumber_emisis');
    }
};
