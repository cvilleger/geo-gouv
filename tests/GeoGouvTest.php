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
        $this->assertNotEmpty(new Client()->getDepartments());
    }

    public function testGetMunicipalitiesByDepartmentCodeIsNotEmpty(): void
    {
        $client = new Client();

        $communes = $client->getMunicipalitiesByDepartmentCode(
            departmentCode: $client->getDepartments()[0]->code,
        );

        $this->assertNotEmpty($communes);
    }

    public function testGetMunicipalitiesByDepartmentCodeWithBadInputThrowException(): void
    {
        $this->expectException(NotFoundException::class);

        new Client()->getMunicipalitiesByDepartmentCode(
            departmentCode: 'test',
        );
    }
}
