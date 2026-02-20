<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property string $title
 * @property string $publisher
 * @property string $genre
 * @property Carbon $publication_date
 * @property string $amount_of_words
 * @property float $price
 * @property-read Author[]|Collection $authors
 */
class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'title',
        'publisher',
        'genre',
        'publication_date',
        'amount_of_words',
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}
