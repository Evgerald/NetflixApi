<?php

namespace Tests\Unit\Api\V1;

use App\DTO\Api\V1\ResourceConfigDto;
use App\Http\Controllers\Api\V1\ReviewApiController;
use App\Http\Requests\Api\V1\ReviewCreateRequest;
use App\Http\Resources\Review\ReviewCollection;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Review;
use Mockery;
use PHPUnit\Framework\TestCase;

class ReviewApiControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * A basic unit test example.
     */
    public function test_store_a_review_and_returns_resource(): void
    {
        // Build data for create
        $data = [
            'user_id' => 'user_07066',
            'movie_id' => 'movie_0415',
            'rating' => 8,
            'review_date' => '2025-08-27',
            'review_text' => 'Great movie with amazing visuals!',
            'device_type' => 'Laptop',
            'is_verified_watch' => true,
            'helpful_votes' => 12,
            'total_votes' => 15,
            'sentiment' => 'positive',
            'sentiment_score' => 0.875
        ];

        // Create config DTO
        $configDto = new ResourceConfigDto(
            model: Review::class,
            resource: ReviewResource::class,
            collection: ReviewCollection::class,
            idField: 'review_id',
            allowedIncludes: [],
            allowedSorts: [],
            allowedFilters: [],
            perPage: 30
        );

        // Create controller
        $controller = new class($configDto) extends ReviewApiController {
            public function __construct(ResourceConfigDto $config)
            {
                $this->config = $config;
            }
        };

        $request = Mockery::mock(ReviewCreateRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($data);
        $review = (object) array_merge($data, ['review_id' => 'review_00001']);
        $query = Mockery::mock();
        $query->shouldReceive('create')->once()->with($data)->andReturn($review);

        Mockery::mock('alias:' . Review::class)
            ->shouldReceive('query')->andReturn($query);

        $response = $controller->store($request);
        $this->assertInstanceOf(ReviewResource::class, $response);
        $this->assertEquals('review_00001', $response->resource->review_id);
    }
}
