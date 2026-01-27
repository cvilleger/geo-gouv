<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Model;

final class Commune
{
    public function __construct(
        public string $nom,
        public string $code,
        public array $codesPostaux,
        public array $coordinates,
        public float $surface,
        public int $population,
        public CommuneDepartement $departement,
        public CommuneRegion $region,
    ) {}
}
