<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Model;

final class Centre
{
    public function __construct(
        public string $type,
        public array $coordinates,
    ) {}
}
