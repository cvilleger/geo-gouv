<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Model;

final readonly class MunicipalityRegion
{
    public function __construct(
        public string $name,
        public string $code,
    ) {}
}
