<?php
declare(strict_types=1);

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\BookResource;
use Database\Factories\BookFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Tests\TestCase;

/**
 * @see BookResource
 */
class BookResourceTest extends TestCase
{
    public function test_resource(): void
    {
        $book = BookFactory::new()->create();
        /** @var Request $request */
        $request = $this->partialMock(Request::class);

        $resource = new BookResource($book)->toArray($request);
        $this->assertSame($book->id, $resource['id']);
        $this->assertSame($book->title, $resource['title']);
        $this->assertSame($book->publisher, $resource['publisher']);
        $this->assertSame($book->genre, $resource['genre']);
        $this->assertSame($book->publication_date->format('Y-m-d'), $resource['publication_date']);
        $this->assertSame($book->amount_of_words, $resource['amount_of_words']);

        $this->assertSame((float) $book->price, (float) ($resource['price'] * 100));
        $this->assertInstanceOf(AnonymousResourceCollection::class, $resource['authors']);
    }
}
