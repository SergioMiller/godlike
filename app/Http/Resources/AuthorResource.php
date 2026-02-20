<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'AuthorResource',
    required: [
        'id',
        'name',
    ],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', maximum: 255, minimum: 1, example: 'Joh doe'),
    ]
)]
/**
 * @property Author $resource
 */
class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
