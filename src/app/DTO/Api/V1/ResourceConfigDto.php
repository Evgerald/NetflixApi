<?php

namespace App\DTO\Api\V1;

/**
 * ResourceConfig Dto
 *
 * @version 1.0
 */
readonly class ResourceConfigDto
{
    public function __construct(
        public string $model,
        public string $resource,
        public string $collection,
        public string $idField,
        public array  $allowedIncludes,
        public array  $allowedSorts,
        public array  $allowedFilters,
        public int    $perPage
    ) {

    }

    /**
     * @param array $globalConfig
     * @param array $modelConfig
     *
     * @return self
     */
    public static function fromArray(array $globalConfig, array $modelConfig): self
    {
        return new self(
            model: $modelConfig['model'],
            resource: $modelConfig['resource'],
            collection: $modelConfig['collection'],
            idField: $modelConfig['id_field'],
            allowedIncludes: $modelConfig['allowed_includes'] ?? [],
            allowedSorts: $modelConfig['allowed_sorts'],
            allowedFilters: $modelConfig['allowed_filters'],
            perPage: $globalConfig['per_page']
        );
    }
}
