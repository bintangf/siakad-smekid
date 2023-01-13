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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('nip', 30);
            $table->string('nama_guru', 50);
            $table->enum('jk', ['L', 'P']);
            $table->string('telp', 15)->nullable();
            $table->string('tmp_lahir', 50)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guru');
    }
};
