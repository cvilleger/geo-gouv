<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Model;

final readonly class Municipality
{
    public function __construct(
        public string $name,
        public string $code,
        public array $postalCodes,
        public array $coordinates,
        public float $surface,
        public int $population,
        public MunicipalityDepartment $department,
        public MunicipalityRegion $region,
    ) {}
}
