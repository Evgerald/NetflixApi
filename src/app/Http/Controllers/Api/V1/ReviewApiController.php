<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ReviewCreateRequest;
use App\Http\Requests\Api\V1\ReviewUpdateRequest;
use App\Http\Resources\Review\ReviewResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * ReviewApi Controller
 *
 * @version 1.0
 */
class ReviewApiController extends BaseApiController
{
    protected string $configKey = 'review';

    /**
     * @param string $id
     *
     * @return Response
     */
    public function destroy(string $id)
    {
        $review = $this->config->model::query()->where($this->config->idField, $id)->firstOrFail();
        $review->where($this->config->idField, $id)->delete();

        return response()->noContent();
    }

    /**
     * @param string $id
     * @param ReviewUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(string $id, ReviewUpdateRequest $request)
    {
        $review = $this->config->model::query()->where($this->config->idField, $id)->firstOrFail();
        $review->update($request->validated());

        return (new $this->config->resource($review))
            ->additional(['message' => 'Review updated successfully'])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * @param ReviewCreateRequest $request
     *
     * @return ReviewResource
     */
    public function store(ReviewCreateRequest $request)
    {
        $review = $this->config->model::query()->create($request->validated());

        return new ReviewResource($review);
    }
}
