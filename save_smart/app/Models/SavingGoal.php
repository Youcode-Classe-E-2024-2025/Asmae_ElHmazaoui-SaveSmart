<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingGoal extends Model
{
    use HasFactory;

    // Nom de la table associée à ce modèle
    protected $table = 'saving_goals';

    // Colonnes qui peuvent être massivement assignées
    protected $fillable = [
        'user_id',
        'name',
        'goal_amount',
        'deadline',
    ];

    // Définir la relation avec le modèle User (relation 1-à-plusieurs)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
