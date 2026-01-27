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
