<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Model;

final class Region
{
    public function __construct(
        public string $nom,
        public string $code,
    ) {}
}
