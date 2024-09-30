<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv;

use Cvilleger\GeoGouv\Model\Centre;
use Cvilleger\GeoGouv\Model\Commune;
use Cvilleger\GeoGouv\Model\CommuneDepartement;
use Cvilleger\GeoGouv\Model\CommuneRegion;
use Cvilleger\GeoGouv\Model\Departement;
use Cvilleger\GeoGouv\Model\Region;

final class Client
{
    private const RESOURCES_DIRECTORY = __DIR__.'/../resources';

    /**
     * @return Departement[]
     */
    public function getDepartements(): array
    {
        $filepath = self::RESOURCES_DIRECTORY.'/departements.json';

        return array_map(static function (array $departement) {
            return new Departement(
                nom: $departement['nom'],
                code: $departement['code'],
                codeRegion: $departement['codeRegion'],
                region: new Region(
                    nom: $departement['nom'],
                    code: $departement['code'],
                ),
            );
        }, $this->getArrayFromFilepath($filepath));
    }

    /**
     * @return Commune[]
     */
    public function getCommunesByDepartementCode(string $departementCode): array
    {
        $filepath = sprintf('%s/commune-departement-%s.json', self::RESOURCES_DIRECTORY, $departementCode);

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
        }, $this->getArrayFromFilepath($filepath));
    }

    private function getArrayFromFilepath(string $filepath): array
    {
        $contents = file_get_contents($filepath);
        if (false === $contents) {
            throw new \RuntimeException('Unable to open file: '.$filepath);
        }

        return json_decode($contents, true);
    }
}
