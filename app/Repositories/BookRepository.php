<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class BookRepository implements BookRepositoryInterface
{
    public function paginator(): LengthAwarePaginator
    {
        return Book::query()->paginate();
    }

    public function getById(int $id): Book|null
    {
        return Book::query()->where('id', $id)->first();
    }

    public function save(Book $model): Book
    {
        $model->save();

        return $model->refresh();
    }

    public function destroy(Book $model): bool
    {
        $model->delete();

        return true;
    }
}
