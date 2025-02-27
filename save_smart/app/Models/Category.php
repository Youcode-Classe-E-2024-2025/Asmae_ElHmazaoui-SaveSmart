<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    // Relation avec la table User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec la table Transaction (une catégorie peut avoir plusieurs transactions)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
