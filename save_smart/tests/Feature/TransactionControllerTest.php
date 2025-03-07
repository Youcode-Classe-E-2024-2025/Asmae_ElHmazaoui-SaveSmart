<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_display_transactions()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user); // Authenticate the user

        $category = Category::factory()->create(['user_id' => $user->id]); // Ensure a category exists for the user
        Transaction::factory()->count(3)->create(['user_id' => $user->id, 'category_id' => $category->id]); // Create transactions associated with the user and category

        // Act
        $response = $this->get(route('transactions.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('Dashboard');
        $response->assertViewHas('transactions');
        $response->assertViewHas('categories');
        //Ajouter ceci:
        //$response->assertViewHas('goals');  //Vérifier que goals est present

        // Assert that only the authenticated user's transactions are displayed
        $transactions = $response->viewData('transactions');
        $this->assertCount(3, $transactions);
        foreach ($transactions as $transaction) {
            $this->assertEquals($user->id, $transaction->user_id);
        }

        $categories = $response->viewData('categories');
        $this->assertCount(1, $categories);
        foreach ($categories as $category) {
            $this->assertEquals($user->id, $category->user_id);
        }
    }

    /** @test */
    public function it_can_store_a_transaction()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['user_id' => $user->id]);

        $transactionData = [
            'amount' => 100,
            'type' => 'Income',
            'categoryId' => $category->id,
            'date' => '2023-10-26',
        ];

        // Act
        $response = $this->post(route('transactions.store'), $transactionData);

        // Assert
        $response->assertRedirect(route('Dashboard'));
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 100,
            'type' => 'Income',
            'date' => '2023-10-26',
        ]);
    }

    /** @test */
    public function it_validates_transaction_store_request()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = [
            'amount' => -10, // Negative amount
            'type' => 'InvalidType', // Invalid type
            'categoryId' => 999, // Non-existent category
            'date' => 'invalid-date', // Invalid date
        ];

        // Act
        $response = $this->post(route('transactions.store'), $invalidData);

        // Assert
        $response->assertSessionHasErrors(['amount', 'type', 'categoryId', 'date']);
    }

    /** @test */
    public function it_can_update_a_transaction()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);

        $updatedData = [
            'amount' => 200,
            'type' => 'Expense',
            'categoryId' => $category->id,
            'date' => '2023-10-27',
        ];

        // Act
        $response = $this->put(route('transactions.update', $transaction->id), $updatedData);

        // Assert
        $response->assertRedirect(route('Dashboard'));
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 200,
            'type' => 'Expense',
            'date' => '2023-10-27',
        ]);
    }

    /** @test */
    public function it_validates_transaction_update_request()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);


        $invalidData = [
            'amount' => -10, // Negative amount
            'type' => 'InvalidType', // Invalid type
            'categoryId' => 999, // Non-existent category
            'date' => 'invalid-date', // Invalid date
        ];

        // Act
        $response = $this->put(route('transactions.update', $transaction->id), $invalidData);

        // Assert
        $response->assertSessionHasErrors(['amount', 'type', 'categoryId', 'date']);
    }

    /** @test */
    public function it_can_destroy_a_transaction()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);

        // Act
        $response = $this->delete(route('transactions.destroy', $transaction->id));

        // Assert
        $response->assertRedirect(route('Dashboard'));
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }

     /** @test */
    public function it_only_allows_users_to_update_their_own_transactions()
    {
        // Arrange
        $user1 = User::factory()->create();
        $this->actingAs($user1);
        $category1 = Category::factory()->create(['user_id' => $user1->id]);
        $transaction1 = Transaction::factory()->create(['user_id' => $user1->id, 'category_id' => $category1->id]);

        $user2 = User::factory()->create();
        $this->actingAs($user2); // Authentification en tant que user2 pour tester
       // $category2 = Category::factory()->create(['user_id' => $user2->id]);

        $updatedData = [
            'amount' => 200,
            'type' => 'Expense',
            'categoryId' => $category1->id, //Utilisation de category1 pour simplifier
            'date' => '2023-10-27',
        ];


        // Act
        $response = $this->put(route('transactions.update', $transaction1->id), $updatedData);

        // Assert
        $response->assertStatus(403);  // Or whatever status code is appropriate for your app when failing authorization.
       // $response->assertSessionHasErrors('id'); // Vérifie que la session contient une erreur avec la clé 'id'
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction1->id,
            'user_id' => $user1->id,  //Assure que la transaction n'a pas été modifiée
        ]);
    }

     /** @test */
    public function it_only_allows_users_to_delete_their_own_transactions()
    {
        // Arrange
        $user1 = User::factory()->create();
        $this->actingAs($user1);

        $category1 = Category::factory()->create(['user_id' => $user1->id]);
        $transaction1 = Transaction::factory()->create(['user_id' => $user1->id, 'category_id' => $category1->id]);

        $user2 = User::factory()->create();
        $this->actingAs($user2); // Authentification en tant que user2 pour tester

        // Act
        $response = $this->delete(route('transactions.destroy', $transaction1->id));

        // Assert
        $response->assertStatus(403);
        //$response->assertSessionHasErrors('id'); // Assurez-vous que l'utilisateur n'est pas autorisé à supprimer la transaction
        $this->assertDatabaseHas('transactions', ['id' => $transaction1->id]);  // Assurez-vous que la transaction existe toujours
    }

     /** @test */
    public function it_returns_404_if_transaction_not_found_during_update()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'amount' => 200,
            'type' => 'Expense',
            'categoryId' => $category->id,
            'date' => '2023-10-27',
        ];

        // Act
        $response = $this->put(route('transactions.update', 999), $updatedData); // Assuming 999 is a non-existent ID

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_if_transaction_not_found_during_delete()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act
        $response = $this->delete(route('transactions.destroy', 999)); // Assuming 999 is a non-existent ID

        // Assert
        $response->assertStatus(404);
    }


}