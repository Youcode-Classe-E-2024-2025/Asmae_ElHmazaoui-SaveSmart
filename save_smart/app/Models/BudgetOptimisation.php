<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetOptimisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'methodoptimisation',
        'detail',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}