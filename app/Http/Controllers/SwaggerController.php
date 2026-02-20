<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use OpenApi\Attributes as OA;

#[
    OA\OpenApi(
        info: new OA\Info(
            version: '1.0.0',
            title: 'Swagger',
        ),
        servers: [
            new OA\Server(
                url: 'http://localhost/',
                description: 'Api localhost'
            ),
        ],
        components: new OA\Components(
            securitySchemes: [
                'bearerAuth' => new OA\SecurityScheme(
                    securityScheme: 'bearerAuth',
                    type: 'http',
                    name: 'Authorization',
                    in: 'header',
                    bearerFormat: 'JWT',
                    scheme: 'bearer',
                ),
            ],
        ),
    ),
    OA\Schema(
        schema: 'Pagination',
        required: ['total', 'current_page', 'last_page'],
        properties: [
            new OA\Property(property: 'total', type: 'integer', example: 20),
            new OA\Property(property: 'current_page', type: 'integer', example: 1),
            new OA\Property(property: 'last_page', type: 'integer', example: 5),
        ]
    )
]
final class SwaggerController extends Controller
{
    public function index(): View
    {
        return view('swagger');
    }

    public function openapi(): bool|string
    {
        return file_get_contents(App::storagePath() . '/app/openapi.yaml');
    }
}
