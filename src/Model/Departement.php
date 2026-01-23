<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Model;

final readonly class Departement
{
    public function __construct(
        public string $nom,
        public string $code,
        public string $codeRegion,
        public string $coordinates,
        public Region $region,
    ) {}
}
