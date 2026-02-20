<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Interfaces\BookRepositoryInterface;
use App\Services\Book\BookService;
use App\Services\Book\Dto\StoreDto;
use App\Services\Book\Dto\UpdateDto;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use OpenApi\Attributes as OA;

/**
 * @see BookControllerTest
 */
final class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
        private readonly BookRepositoryInterface $booksRepository,
    ) {
    }

    #[
        OA\Get(
            path: '/api/books',
            description: 'Return a books list.',
            tags: ['Book'],
        ),
        OA\Response(
            response: Response::HTTP_OK,
            description: 'Successful.',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'pagination', ref: '#/components/schemas/Pagination'),
                    //                    new OA\Property(property: 'data', ref: '#/components/schemas/BookResource'),
                    new OA\Property(property: 'data', type: 'array', items: new OA\Items(
                        ref: '#/components/schemas/BookResource'
                    )),
                ]
            ),
        ),
    ]
    public function index(): JsonResponse
    {
        $paginator = $this->booksRepository->paginator();

        return new JsonResponse(
            data: [
                'pagination' => [
                    'total' => $paginator->total(),
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                ],
                'data' => BookResource::collection($paginator->items()),
            ],
            status: Response::HTTP_OK
        );
    }

    /**
     * @throws Throwable
     */
    #[
        OA\Post(
            path: '/api/books',
            description: 'Create a book.',
            tags: ['Book'],
        ),
        OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/StoreBookRequest'),
        ),
        OA\Response(
            response: Response::HTTP_CREATED,
            description: 'Successful.',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'data', ref: '#/components/schemas/BookResource'),
                ]
            ),
        ),
    ]
    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = $this->bookService->store(StoreDto::fromArray($request->validated()));

        return new JsonResponse(
            data: [
                'data' => new BookResource($book),
            ],
            status: Response::HTTP_CREATED
        );
    }

    #[
        OA\Get(
            path: '/api/books/{id}',
            description: 'Return the books by id.',
            tags: ['Book'],
        ),
        OA\Parameter(
            name: 'id',
            description: 'Id of the book.',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
        OA\Response(
            response: Response::HTTP_OK,
            description: 'Successful.',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'data', ref: '#/components/schemas/BookResource'),
                ]
            ),
        ),
        OA\Response(
            response: Response::HTTP_NOT_FOUND,
            description: 'Not found.',
        ),
    ]
    public function show(int $id): JsonResponse
    {
        $book = $this->booksRepository->getById($id);

        abort_if(null === $book, Response::HTTP_NOT_FOUND);

        return new JsonResponse(
            data: [
                'data' => new BookResource($book)
            ],
            status: Response::HTTP_OK
        );
    }

    /**
     * @throws Throwable
     */
    #[
        OA\Patch(
            path: '/api/books/{id}',
            description: 'Update the books by id.',
            tags: ['Book'],
        ),
        OA\Parameter(
            name: 'id',
            description: 'Id of the book.',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
        OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateBookRequest'),
        ),
        OA\Response(
            response: Response::HTTP_OK,
            description: 'Successful.',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'data', ref: '#/components/schemas/BookResource'),
                ]
            ),
        ),
        OA\Response(
            response: Response::HTTP_NOT_FOUND,
            description: 'Not found.',
        ),
    ]
    public function update(int $id, UpdateBookRequest $request): JsonResponse
    {
        $book = $this->booksRepository->getById($id);

        abort_if(null === $book, Response::HTTP_NOT_FOUND);

        $book = $this->bookService->update($book, UpdateDto::fromArray($request->validated()));

        return new JsonResponse([
            'data' => new BookResource($book)
        ]);
    }

    #[
        OA\Delete(
            path: '/api/books/{id}',
            description: 'Update the books by id.',
            tags: ['Book'],
        ),
        OA\Parameter(
            name: 'id',
            description: 'Id of the book.',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
        OA\Response(
            response: Response::HTTP_NO_CONTENT,
            description: 'Successful.',
        ),
        OA\Response(
            response: Response::HTTP_NOT_FOUND,
            description: 'Not found.',
        ),
    ]
    public function destroy(int $id): JsonResponse
    {
        $book = $this->booksRepository->getById($id);

        abort_if(null === $book, Response::HTTP_NOT_FOUND);

        $this->bookService->destroy($book);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
