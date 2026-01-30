<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv;

use Cvilleger\GeoGouv\Exception\NotFoundException;
use Cvilleger\GeoGouv\Model\Commune;
use Cvilleger\GeoGouv\Model\CommuneDepartement;
use Cvilleger\GeoGouv\Model\CommuneRegion;
use Cvilleger\GeoGouv\Model\Departement;
use Cvilleger\GeoGouv\Model\Region;
use Cvilleger\GeoGouv\Provider\CoordinatesProvider;

final readonly class Client
{
    private const string RESOURCES_DIRECTORY = __DIR__.'/../resources';

    /**
     * @return Departement[]
     */
    public function getDepartements(): array
    {
        $filename = 'departments.json';
        $departements = [];
        foreach ($this->getDataFromFilename($filename) as $departement) {
            $departements[] = new Departement(
                nom: $departement['nom'],
                code: $departement['code'],
                codeRegion: $departement['codeRegion'],
                coordinates: new CoordinatesProvider()->getByDepartementCode($departement['code']),
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
        $filename = 'department-'.$departementCode.'.json';

        return array_map(static fn (array $commune): Commune => new Commune(
            nom: $commune['nom'],
            code: $commune['code'],
            codesPostaux: $commune['codesPostaux'],
            coordinates: $commune['centre']['coordinates'],
            surface: $commune['surface'],
            population: $commune['population'],
            departement: new CommuneDepartement(
                nom: $commune['departement']['nom'],
                code: $commune['departement']['code'],
            ),
            region: new CommuneRegion(
                nom: $commune['region']['nom'],
                code: $commune['region']['code'],
            ),
        ), $this->getDataFromFilename($filename));
    }

    private function getDataFromFilename(string $filename): array
    {
        $filepath = self::RESOURCES_DIRECTORY.'/'.$filename;
        if (false === file_exists($filepath)) {
            throw new NotFoundException('JSON file not found: '.$filepath);
        }

        $contents = file_get_contents($filepath);
        if (false === $contents) {
            throw new \RuntimeException('Unable to open JSON file');
        }

        try {
            $arrayContent = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $jsonException) {
            throw new \RuntimeException('Unable to parse JSON: '.$jsonException->getMessage(), $jsonException->getCode(), $jsonException);
        }

        if (false === is_array($arrayContent)) {
            throw new \RuntimeException('Unable to parse JSON string');
        }

        return $arrayContent;
    }
}
