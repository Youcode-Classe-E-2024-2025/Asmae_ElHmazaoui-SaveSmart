<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable(); // Email de l'invité (optionnel, peut-être juste un lien de partage)
            $table->string('token')->unique();
            $table->unsignedBigInteger('family_account_id'); // L'ID du compte familial à rejoindre
            $table->unsignedBigInteger('invited_by'); // L'ID de l'utilisateur qui a envoyé l'invitation
            $table->timestamps();

            $table->foreign('family_account_id')->references('id')->on('family_accounts')->onDelete('cascade');
            $table->foreign('invited_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}