<?php
declare(strict_types=1);

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\StoreBookRequest;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Generator;
use Illuminate\Support\Str;
use Illuminate\Validation\Factory as Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Container\ContainerExceptionInterface;
use Tests\TestCase;

/**
 * @var StoreBookRequest
 */
class StoreBookRequestTest extends TestCase
{
    private Validator $validator;

    /**
     * @throws ContainerExceptionInterface
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = $this->app->get('validator');
    }

    #[DataProvider('dataProvider')]
    public function test_request(array $body, array $expected): void
    {
        $result = $this->validator->make($body, new StoreBookRequest()->rules());

        $this->assertSame($result->errors()->messages(), $expected);
    }

    public static function dataProvider(): Generator
    {
        $faker = Faker::create();

        yield 'good' => [
            'body' => [
                'title' => $faker->word,
                'publisher' => $faker->word,
                'genre' => $faker->word,
                'publication_date' => $faker->date,
                'amount_of_words' => $faker->randomDigitNotZero(),
                'price' => $faker->randomNumber(2),
                'authors' => [1, 2, 3],
            ],
            'expected' => [],
        ];

        yield 'empty body' => [
            'body' => [],
            'expected' => [
                'title' => ['The title field is required.'],
                'publisher' => ['The publisher field is required.'],
                'genre' => ['The genre field is required.'],
                'publication_date' => ['The publication date field is required.'],
                'amount_of_words' => ['The amount of words field is required.'],
                'price' => ['The price field is required.'],
            ],
        ];

        yield 'bad data' => [
            'body' => [
                'title' => Str::random(256),
                'publisher' => Str::random(256),
                'genre' => Str::random(256),
                'publication_date' => Carbon::now()->format('Y-m-d'),
                'amount_of_words' => 99999999999999999999999,
                'price' => 99999999999999999999999,
                'authors' => ['qwerty', 'qwerty', 'qwerty'],
            ],
            'expected' => [
                'title' => ['The title field must not be greater than 255 characters.'],
                'publisher' => ['The publisher field must not be greater than 255 characters.'],
                'genre' => ['The genre field must not be greater than 255 characters.'],
                'amount_of_words' => [
                    'The amount of words field must be an integer.',
                    'The amount of words field must not be greater than 50000.',
                ],
                'price' => ['The price field must not be greater than 999999.'],
                'authors.0' => ['The authors.0 field must be an integer.'],
                'authors.1' => ['The authors.1 field must be an integer.'],
                'authors.2' => ['The authors.2 field must be an integer.'],
            ],
        ];
    }
}
