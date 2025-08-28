<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Api\V1\ResourceConfigDto;
use App\Http\Controllers\Controller;
use App\Services\Api\V1\ApiQueryBuilder;
use Illuminate\Http\Request;

/**
 * BaseApi Controller
 *
 * @version 1.0
 */
abstract class BaseApiController extends Controller
{
    private const CONFIG_PREFIX = 'api_v1';

    protected ResourceConfigDto $config;

    public function __construct()
    {
        $this->config = ResourceConfigDto::fromArray(
            config(self::CONFIG_PREFIX),
            config(self::CONFIG_PREFIX . ".{$this->configKey}")
        );
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $apiQueryBuilder = new ApiQueryBuilder($this->config->model::query(), $request);
        $result = $apiQueryBuilder
            ->applySorting($this->config->allowedSorts)
            ->applyIncludes($this->config->allowedIncludes)
            ->applyFilters($this->config->allowedFilters)
            ->applyPagination($this->config->perPage);

        return new $this->config->collection($result);
    }

    /**
     * @param string $id
     * @param Request $request
     *
     * @return mixed
     */
    public function show(string $id, Request $request)
    {
        $apiQueryBuilder = new ApiQueryBuilder($this->config->model::query(), $request);
        $result = $apiQueryBuilder
            ->applyIncludes($this->config->allowedIncludes)
            ->apply()
            ->where($this->config->idField, $id)
            ->firstOrFail();

        return new $this->config->resource($result);
    }
}
