<?php

declare(strict_types=1);

namespace Cvilleger\Test\GeoGouv;

use Cvilleger\GeoGouv\Client;
use Cvilleger\GeoGouv\Exception\NotFoundException;
use Cvilleger\GeoGouv\Model\Centre;
use Cvilleger\GeoGouv\Model\Commune;
use Cvilleger\GeoGouv\Model\CommuneDepartement;
use Cvilleger\GeoGouv\Model\CommuneRegion;
use Cvilleger\GeoGouv\Model\Departement;
use Cvilleger\GeoGouv\Model\Region;
use Cvilleger\GeoGouv\Provider\CoordinatesProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Client::class)]
#[CoversClass(CoordinatesProvider::class)]
#[CoversClass(Centre::class)]
#[CoversClass(Commune::class)]
#[CoversClass(CommuneDepartement::class)]
#[CoversClass(CommuneRegion::class)]
#[CoversClass(Departement::class)]
#[CoversClass(Region::class)]
final class GeoGouvTest extends TestCase
{
    public function testGetDepartmentsIsNotEmpty(): void
    {
        $this->assertNotEmpty(new Client()->getDepartements());
    }

    public function testGetCommunesByDepartementCodeIsNotEmpty(): void
    {
        $client = new Client();

        foreach ($client->getDepartements() as $departement) {
            $this->assertNotEmpty($client->getCommunesByDepartementCode($departement->code));
        }
    }

    public function testGetMunicipalitiesByDepartmentCodeWithBadInputThrowException(): void
    {
        $this->expectException(NotFoundException::class);

        new Client()->getCommunesByDepartementCode(
            departementCode: 'notADepartementCode',
        );
    }
}
