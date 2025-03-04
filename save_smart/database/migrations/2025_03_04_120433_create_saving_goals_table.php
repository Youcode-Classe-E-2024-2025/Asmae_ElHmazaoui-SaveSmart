<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('saving_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // relation 1-to-many avec la table users
            $table->string('name');
            $table->decimal('goal_amount', 15, 2); // Montant de l'objectif d'épargne
            $table->date('deadline'); // Date limite de l'objectif
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saving_goals');
    }
};
