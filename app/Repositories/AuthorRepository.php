<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Support\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function getByIds(array $ids): Collection
    {
        return Author::query()->whereIn('id', $ids)->get();
    }
}
