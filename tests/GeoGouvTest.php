<?php

declare(strict_types=1);

namespace Cvilleger\Test\GeoGouv;

use Cvilleger\GeoGouv\Client;
use Cvilleger\GeoGouv\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class GeoGouvTest extends TestCase
{
    public function testGetDepartmentsIsNotEmpty(): void
    {
        $departements = new Client()->getDepartements();

        $this->assertNotEmpty($departements);
    }

    public function testGetCommunesByDepartementCodeIsNotEmpty(): void
    {
        $client = new Client();

        $departement = $client->getDepartements()[0];
        $communes = $client->getCommunesByDepartementCode(
            departementCode: $departement->code,
        );

        $this->assertNotEmpty($communes);
    }

    public function testGetCommunesByDepartementName(): void
    {
        $this->expectException(NotFoundException::class);

        new Client()->getCommunesByDepartementCode(
            departementCode: 'test',
        );
    }
}
