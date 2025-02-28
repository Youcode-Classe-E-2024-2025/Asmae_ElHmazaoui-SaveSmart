<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('family_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->nullable(); // Ajout de la colonne avatar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('family_accounts');
    }
};
