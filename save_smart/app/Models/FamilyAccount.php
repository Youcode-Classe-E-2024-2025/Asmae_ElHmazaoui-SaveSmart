<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAccount extends Model
{
    use HasFactory;

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'name',
        'avatar',
    ];

    /**
     * Fonction qui permet de récupérer les profils associés à ce compte familial.
     */
    public function users()
    {
        return $this->hasMany(User::class); // Relation One-to-Many
    }
}
