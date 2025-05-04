<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv;

use Cvilleger\GeoGouv\Model\Centre;
use Cvilleger\GeoGouv\Model\Commune;
use Cvilleger\GeoGouv\Model\CommuneDepartement;
use Cvilleger\GeoGouv\Model\CommuneRegion;
use Cvilleger\GeoGouv\Model\Departement;
use Cvilleger\GeoGouv\Model\Region;
use Cvilleger\GeoGouv\Provider\CoordinatesProvider;

final class Client
{
    private const string RESOURCES_DIRECTORY = __DIR__.'/../resources';

    /**
     * @return Departement[]
     */
    public function getDepartements(): array
    {
        $filename = 'departements.json';
        $departements = [];
        foreach ($this->getDataFromFilename($filename) as $departement) {
            $departements[] = new Departement(
                nom: $departement['nom'],
                code: $departement['code'],
                codeRegion: $departement['codeRegion'],
                coordinates: (new CoordinatesProvider())->getByDepartementCode($departement['code']),
                region: new Region(
                    nom: $departement['region']['nom'],
                    code: $departement['region']['code'],
                ),
            );
        }

        return $departements;
    }

    /**
     * @return Commune[]
     */
    public function getCommunesByDepartementCode(string $departementCode): array
    {
        $filename = 'commune-departement-'.$departementCode.'.json';

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
                population: $commune['population'] ?? 0, // Default to 0 if not present like 12320 Conques-en-Rouergue
                departement: new CommuneDepartement(
                    nom: $commune['departement']['nom'],
                    code: $commune['departement']['code'],
                ),
                region: new CommuneRegion(
                    nom: $commune['region']['nom'],
                    code: $commune['region']['code'],
                ),
            );
        }, $this->getDataFromFilename($filename));
    }

    private function getDataFromFilename(string $filename): array
    {
        $filepath = self::RESOURCES_DIRECTORY.'/'.$filename;

        $contents = file_get_contents($filepath);
        if (false === $contents) {
            throw new \RuntimeException('Unable to open JSON file');
        }

        try {
            $arrayContent = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException('Unable to parse JSON: '.$e->getMessage(), $e->getCode(), $e);
        }

        if (false === is_array($arrayContent)) {
            throw new \RuntimeException('Unable to parse JSON string');
        }

        return $arrayContent;
    }
}
