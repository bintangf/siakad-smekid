<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guru_mapel', function (Blueprint $table) {
            $table->unsignedBigInteger('guru_id')->index();
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->unsignedBigInteger('mapel_id')->index();
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
            $table->primary(['guru_id', 'mapel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guru_mapel');
    }
};
