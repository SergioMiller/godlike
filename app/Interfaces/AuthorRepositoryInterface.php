<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface AuthorRepositoryInterface
{
    public function getByIds(array $ids): Collection;
}
