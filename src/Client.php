<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv;

use Cvilleger\GeoGouv\Exception\NotFoundException;
use Cvilleger\GeoGouv\Model\Center;
use Cvilleger\GeoGouv\Model\Department;
use Cvilleger\GeoGouv\Model\Municipality;
use Cvilleger\GeoGouv\Model\MunicipalityDepartment;
use Cvilleger\GeoGouv\Model\MunicipalityRegion;
use Cvilleger\GeoGouv\Model\Region;
use Cvilleger\GeoGouv\Provider\CoordinatesProvider;

final readonly class Client
{
    private const string RESOURCES_DIRECTORY = __DIR__.'/../resources';

    /**
     * @return Department[]
     */
    public function getDepartments(): array
    {
        $filename = 'departements.json';
        $departements = [];
        foreach ($this->getDataFromFilename($filename) as $departement) {
            $departements[] = new Department(
                name: $departement['nom'],
                code: $departement['code'],
                regionCode: $departement['codeRegion'],
                coordinates: new CoordinatesProvider()->getByDepartmentCode(
                    departmentCode: $departement['code'],
                ),
                region: new Region(
                    name: $departement['region']['nom'],
                    code: $departement['region']['code'],
                ),
            );
        }

        return $departements;
    }

    /**
     * @return Municipality[]
     */
    public function getMunicipalitiesByDepartmentCode(string $departmentCode): array
    {
        $filename = 'commune-departement-'.$departmentCode.'.json';

        return array_map(static fn (array $commune): Municipality => new Municipality(
            name: $commune['nom'],
            code: $commune['code'],
            postalCodes: $commune['codesPostaux'],
            coordinates: $commune['centre']['coordinates'],
            surface: $commune['surface'],
            population: $commune['population'] ?? 0, // Default to 0 if not present like 12320 Conques-en-Rouergue
            department: new MunicipalityDepartment(
                name: $commune['departement']['nom'],
                code: $commune['departement']['code'],
            ),
            region: new MunicipalityRegion(
                name: $commune['region']['nom'],
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
