<?php

namespace Database\Factories;

use App\Models\FamilyAccount; // Importez le modèle correspondant
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyAccount>
 */
class FamilyAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FamilyAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Définissez ici les attributs par défaut de votre FamilyAccount
            'name' => $this->faker->company,
            // Ajoutez d'autres attributs selon votre modèle
        ];
    }
}