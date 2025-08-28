<?php

namespace App\Services\Api\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * ApiQuery Builder
 *
 * @version 1.0
 */
class ApiQueryBuilder
{
    protected Builder $query;

    protected Request $request;

    public function __construct(Builder $query, Request $request)
    {
        $this->query = $query;
        $this->request = $request;
    }

    /**
     * @return Builder
     */
    public function apply(): Builder
    {
        return $this->query;
    }

    /**
     * @param array $allowedFields
     *
     * @return $this
     */
    public function applyIncludes(array $allowedFields): static
    {
        $includes = array_filter(explode(',', $this->request->get('include', '')));
        $validIncludes = array_intersect($includes, $allowedFields);
        $this->query->with($validIncludes);

        return $this;
    }

    /**
     * @param int $maxPerPage
     *
     * @return LengthAwarePaginator
     */
    public function applyPagination(int $maxPerPage): LengthAwarePaginator
    {
        $perPage = $maxPerPage;

        if (
            $this->request->has('per_page')
            && filter_var($value = $this->request->get('per_page'), FILTER_VALIDATE_INT) !== false
            && $value > 0
            && $value < $perPage
        ) {
            $perPage = $value;
        }

        return $this->query->paginate($perPage);
    }

    /**
     * @param array $allowedFields
     *
     * @return $this
     */
    public function applySorting(array $allowedFields): static
    {
        if ($this->request->has('sort')) {
            $sortString = $this->request->get('sort');
            $direction = 'asc';

            if (str_starts_with($sortString, '-')) {
                $direction = 'desc';
                $sortString = ltrim($sortString, '-');
            }

            $sortFields = explode(',', $sortString);
            foreach ($sortFields as $field) {
                if (in_array($field, $allowedFields)) {
                    $this->query->orderBy($field, $direction);
                }
            }
        }

        return $this;
    }

    /**
     * @param array $allowedFields
     *
     * @return $this
     */
    public function applyFilters(array $allowedFields): static
    {
        if ($this->request->has('filter')) {
            foreach ($this->request->get('filter') as $field => $value) {
                if (in_array($field, $allowedFields)) {
                    $this->query->where($field, $value);
                }
            }
        }

        return $this;
    }
}
