<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bieumau', function (Blueprint $table) {
            $table->id();
            $table->string('tenbieumau');
            $table->string('tentaptin');
            $table->integer('create_at');
            $table->string('loai')->default('thietbi');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bieumau');
    }
};