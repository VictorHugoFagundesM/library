<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookLoan>
 */
class BookLoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::all()->random(1)->first()->id;
        $bookId = Book::all()->random(1)->first()->id;
        $isReturned = fake()->boolean();
        return [
            'is_returned' => $isReturned,
            'past_due_time' => fake()->boolean(),
            'return_date' => fake()->date(),
            'returned_at' => $isReturned ? fake()->date() : null,
            'user_id' => $userId,
            'book_id' => $bookId,
        ];
    }
}
