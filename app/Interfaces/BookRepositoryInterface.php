<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookRepositoryInterface
{
    public function paginator(): LengthAwarePaginator;

    public function getById(int $id): Book|null;

    public function save(Book $model): Book;

    public function destroy(Book $model): bool;
}
