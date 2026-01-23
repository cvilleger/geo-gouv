[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/cvilleger/geo-gouv/ci.yml?style=for-the-badge&branch=main)](https://github.com/cvilleger/geo-gouv/actions/workflows/ci.yml)
[![Packagist Version](https://img.shields.io/packagist/v/cvilleger/geo-gouv?style=for-the-badge)](https://packagist.org/packages/cvilleger/geo-gouv)
[![Packagist Downloads](https://img.shields.io/packagist/dt/cvilleger/geo-gouv?style=for-the-badge)](https://packagist.org/packages/cvilleger/geo-gouv)
[![GitHub License](https://img.shields.io/github/license/cvilleger/geo-gouv?style=for-the-badge)](https://github.com/cvilleger/geo-gouv?tab=MIT-1-ov-file#readme)

# cvilleger/geo-gouv

## About

Query geographic reference data using offline data from 🇫🇷 [Gouv administrative division API](https://geo.api.gouv.fr/decoupage-administratif).

## Features

- Query all departments data
- Query all municipalities by department code

## Requirements

- PHP 8.5 or above

## Installation

Install this package as a dependency using [Composer](https://getcomposer.org).

``` bash
  composer require cvilleger/geo-gouv
```
*Note that this package has **zero composer dependencies.***

## Usage

### Retrieve departments

``` php
use Cvilleger\GeoGouv\Client;

$client = new Client();

$departments = $client->getDepatements();

print_r($departments[0]);
/*
Cvilleger\GeoGouv\Model\Department Object
(
    [name] => Ain
    [code] => 01
    [regionCode] => 84
    [coordinates] => 46.06551335, 5.28478031423462
    [region] => Cvilleger\GeoGouv\Model\Region Object
        (
            [name] => Auvergne-Rhône-Alpes
            [code] => 84
        )

)
*/
```

### Retrieve municipalities by department code

``` php
use Cvilleger\GeoGouv\Client;

$client = new Client();

$municipalities = $client->getMunicipalitiesByDepartmentCode('01');

print_r($municipalities[0]);
/*
(
    [name] => L'Abergement-Clémenciat
    [code] => 01001
    [postalCodes] => Array
        (
            [0] => 01400
        )

    [center] => Cvilleger\GeoGouv\Model\Center Object
        (
            [coordinates] => Array
                (
                    [0] => 4.9306
                    [1] => 46.1517
                )

        )

    [surface] => 1564.5
    [population] => 832
    [department] => Cvilleger\GeoGouv\Model\MunicipalityDepartment Object
        (
            [name] => Ain
            [code] => 01
        )

    [region] => Cvilleger\GeoGouv\Model\MunicipalitRegion Object
        (
            [name] => Auvergne-Rhône-Alpes
            [code] => 84
        )

)
*/
```
