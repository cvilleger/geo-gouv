<?php

declare(strict_types=1);

namespace Cvilleger\Test\GeoGouv;

use Cvilleger\GeoGouv\Client;
use Cvilleger\GeoGouv\Model\Commune;
use Cvilleger\GeoGouv\Model\Departement;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class GeoGouvTest extends TestCase
{
    public function testGetDepartments(): void
    {
        $client = new Client();

        $departements = $client->getDepartements();

        $this->assertNotEmpty($departements);
        $this->assertInstanceOf(Departement::class, $departements[0]);
    }

    public function testGetCommunesByDepartementCode(): void
    {
        $client = new Client();

        $departement = $client->getDepartements()[0];
        $communes = $client->getCommunesByDepartementCode($departement->code);

        $this->assertNotEmpty($communes);
        $this->assertInstanceOf(Commune::class, $communes[0]);
    }
}
