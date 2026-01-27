<?php

declare(strict_types=1);

namespace Cvilleger\Test\GeoGouv;

use Cvilleger\GeoGouv\Client;
use Cvilleger\GeoGouv\Exception\NotFoundException;
use Cvilleger\GeoGouv\Model\Commune;
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
        $this->assertNotEmpty(new Client()->getDepartements());
    }

    public function testGetCommunesByDepartementCode(): void
    {
        $client = new Client();

        $departement = $client->getDepartements()[0];
        $communes = $client->getCommunesByDepartementCode($departement->code);

        $this->assertNotEmpty($communes);
        $this->assertInstanceOf(Commune::class, $communes[0]);
    }

    public function testGetMunicipalitiesByDepartmentCodeIsNotEmpty(): void
    {
        $client = new Client();

        $communes = $client->getCommunesByDepartementCode(
            departementCode: $client->getDepartements()[0]->code,
        );

        $this->assertNotEmpty($communes);
    }

    public function testGetMunicipalitiesByDepartmentCodeWithBadInputThrowException(): void
    {
        $this->expectException(NotFoundException::class);

        new Client()->getCommunesByDepartementCode(
            departementCode: 'notADepartementCode',
        );
    }
}
