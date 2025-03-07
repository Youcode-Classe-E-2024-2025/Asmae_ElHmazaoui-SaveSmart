<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Category; // Important: Importer le model Category
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),  // Important: Assurez-vous d'avoir une factory Category fonctionnelle
            'amount' => $this->faker->numberBetween(10, 1000), // Montant aléatoire entre 10 et 1000
            'type' => $this->faker->randomElement(['Income', 'Expense']), // 'Income' ou 'Expense' aléatoirement
            'date' => $this->faker->date(), // Date aléatoire
            // Ajoutez d'autres attributs et leurs valeurs par défaut ici
        ];
    }
}