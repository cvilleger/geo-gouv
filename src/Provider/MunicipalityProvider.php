<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Provider;

final class MunicipalityProvider extends AbstractProvider
{
    public function getMunicipalities(string $departmentCode): array
    {
        return $this->getArrayFromFilename('commune-departement-'.$departmentCode.'.json');
    }
}
