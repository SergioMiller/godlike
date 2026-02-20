<?php
declare(strict_types=1);

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\AuthorResource;
use Database\Factories\AuthorFactory;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * @see AuthorResource
 */
class AuthorResourceTest extends TestCase
{
    public function test_resource(): void
    {
        $book = AuthorFactory::new()->create();
        /** @var Request $request */
        $request = $this->partialMock(Request::class);

        $resource = new AuthorResource($book)->toArray($request);
        $this->assertSame($book->id, $resource['id']);
        $this->assertSame($book->name, $resource['name']);
    }
}
