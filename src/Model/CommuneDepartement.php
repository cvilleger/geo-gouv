<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Model;

final class CommuneDepartement
{
    public function __construct(
        public string $nom,
        public string $code,
    ) {}
}
