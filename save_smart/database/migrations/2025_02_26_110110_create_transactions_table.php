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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key vers la table users
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key vers la table categories
            $table->decimal('amount', 10, 2); // Montant avec 10 chiffres au total, dont 2 après la virgule
            $table->enum('type', ['Income', 'Expense']); // Type de transaction (Income ou Expense)
            $table->date('date'); // Date de la transaction
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
        Schema::dropIfExists('transactions');
    }
};