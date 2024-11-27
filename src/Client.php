<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv;

use Cvilleger\GeoGouv\Model\Centre;
use Cvilleger\GeoGouv\Model\Commune;
use Cvilleger\GeoGouv\Model\CommuneDepartement;
use Cvilleger\GeoGouv\Model\CommuneRegion;
use Cvilleger\GeoGouv\Model\Departement;
use Cvilleger\GeoGouv\Model\Region;
use Cvilleger\GeoGouv\Provider\DepartementProvider;
use Cvilleger\GeoGouv\Provider\MunicipalityProvider;

final class Client
{
    private DepartementProvider $departementProvider;
    private MunicipalityProvider $municipalityProvider;

    public function __construct()
    {
        $this->departementProvider = new DepartementProvider();
        $this->municipalityProvider = new MunicipalityProvider();
    }

    /**
     * @return Departement[]
     */
    public function getDepartements(): array
    {
        return array_map(static function (array $departement) {
            return new Departement(
                nom: $departement['nom'],
                code: $departement['code'],
                codeRegion: $departement['codeRegion'],
                region: new Region(
                    nom: $departement['region']['nom'],
                    code: $departement['region']['code'],
                ),
            );
        }, $this->departementProvider->getDepartments());
    }

    /**
     * @return Commune[]
     */
    public function getCommunesByDepartementCode(string $departmentCode): array
    {
        return array_map(static function (array $commune) {
            return new Commune(
                nom: $commune['nom'],
                code: $commune['code'],
                codesPostaux: $commune['codesPostaux'],
                centre: new Centre(
                    type: $commune['centre']['type'],
                    coordinates: $commune['centre']['coordinates'],
                ),
                surface: $commune['surface'],
                population: $commune['population'] ?? 0,
                departement: new CommuneDepartement(
                    nom: $commune['departement']['nom'],
                    code: $commune['departement']['code'],
                ),
                region: new CommuneRegion(
                    nom: $commune['region']['nom'],
                    code: $commune['region']['code'],
                ),
            );
        }, $this->municipalityProvider->getMunicipalities($departmentCode));
    }
}
