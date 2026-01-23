<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Model;

final readonly class Department
{
    public function __construct(
        public string $name,
        public string $code,
        public string $regionCode,
        public string $coordinates,
        public Region $region,
    ) {}
}
