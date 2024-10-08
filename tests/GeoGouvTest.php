<?php

declare(strict_types=1);

namespace Cvilleger\Test\GeoGouv;

use Cvilleger\GeoGouv\Client;
use Cvilleger\GeoGouv\Model\Commune;
use Cvilleger\GeoGouv\Model\Departement;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class GeoGouvTest extends TestCase
{
    public function testGetDepartments(): void
    {
        $client = new Client();

        $departements = $client->getDepartements();

        self::assertIsArray($departements);
        self::assertNotEmpty($departements);
        self::assertInstanceOf(Departement::class, $departements[0]);
    }

    public function testGetCommunesByDepartementCode(): void
    {
        $client = new Client();

        foreach ($client->getDepartements() as $departement) {
            $communes = $client->getCommunesByDepartementCode($departement->code);

            self::assertIsArray($communes);
            self::assertNotEmpty($communes);
            self::assertInstanceOf(Commune::class, $communes[0]);
        }
    }
}
