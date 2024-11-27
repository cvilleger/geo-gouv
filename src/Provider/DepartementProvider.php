<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Provider;

final class DepartementProvider extends AbstractProvider
{
    public function getDepartments(): array
    {
        return $this->getArrayFromFilename('departements.json');
    }
}
