<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'type',
        'date',
    ];

    // Relation avec la table User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec la table Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}