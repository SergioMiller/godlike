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

final class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
        private readonly BookRepositoryInterface $booksRepository,
    ) {
    }

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
    public function update(int $id, UpdateBookRequest $request): JsonResponse
    {
        $book = $this->booksRepository->getById($id);

        abort_if(null === $book, Response::HTTP_NOT_FOUND);

        $book = $this->bookService->update($book, UpdateDto::fromArray($request->validated()));

        return new JsonResponse([
            'data' => new BookResource($book)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $book = $this->booksRepository->getById($id);

        abort_if(null === $book, Response::HTTP_NOT_FOUND);

        $this->bookService->destroy($book);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
