<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use App\Models\Review;

class AssignRandomRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:random-ratings {--min=1} {--max=5} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atribui uma nota aleatória (1-5) a cada livro: cria uma review se não existir, ou atualiza a primeira existente.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $min = (int) $this->option('min');
        $max = (int) $this->option('max');

        if ($min < 1) $min = 1;
        if ($max > 5) $max = 5;
        if ($min > $max) {
            $this->error('Opções inválidas: min maior que max');
            return 1;
        }

        $created = 0;
        $updated = 0;

        // Para cada livro, garantimos exatamente UMA avaliação atribuída: se não existir, criamos; se existir, atualizamos a primeira.
        Book::with('reviews')->chunk(100, function ($books) use (&$created, &$updated, $min, $max) {
            foreach ($books as $book) {
                $rating = rand($min, $max);

                if ($book->reviews->isEmpty()) {
                    $review = new Review();
                    $review->review = "Avaliação automática: {$rating} estrela" . ($rating > 1 ? 's' : '');
                    $review->rating = $rating;
                    $book->reviews()->save($review);
                    // também armazenar a nota diretamente no livro
                    $book->rating = $rating;
                    $book->save();
                    $created++;
                } else {
                    $first = $book->reviews->first();
                    $first->rating = $rating;
                    if (empty(trim($first->review))) {
                        $first->review = "Avaliação automática: {$rating} estrela" . ($rating > 1 ? 's' : '');
                    }
                    $first->save();
                    // atualizar nota agregada no livro
                    $book->rating = $rating;
                    $book->save();
                    $updated++;
                }
            }
        });

        $this->info("Processamento finalizado: {$created} avaliações criadas, {$updated} avaliações atualizadas. (1 por livro)");

        return 0;
    }
}
