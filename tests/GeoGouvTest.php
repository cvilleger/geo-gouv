<?php

declare(strict_types=1);

namespace Cvilleger\Test\GeoGouv;

use Cvilleger\GeoGouv\Client;
use Cvilleger\GeoGouv\Model\Centre;
use Cvilleger\GeoGouv\Model\Commune;
use Cvilleger\GeoGouv\Model\CommuneDepartement;
use Cvilleger\GeoGouv\Model\CommuneRegion;
use Cvilleger\GeoGouv\Model\Departement;
use Cvilleger\GeoGouv\Model\Region;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Client::class)]
#[CoversClass(Departement::class)]
#[CoversClass(Region::class)]
#[CoversClass(Centre::class)]
#[CoversClass(Commune::class)]
#[CoversClass(CommuneDepartement::class)]
#[CoversClass(CommuneRegion::class)]
class GeoGouvTest extends TestCase
{
    public function testGetDepartments(): void
    {
        $client = new Client();

        $departements = $client->getDepartements();

        self::assertNotEmpty($departements);
        self::assertInstanceOf(Departement::class, $departements[0]);
    }

    public function testGetCommunesByDepartementCode(): void
    {
        $client = new Client();

        foreach ($client->getDepartements() as $departement) {
            $communes = $client->getCommunesByDepartementCode($departement->code);

            self::assertNotEmpty($communes);
            self::assertInstanceOf(Commune::class, $communes[0]);
        }
    }
}
