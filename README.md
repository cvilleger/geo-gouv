[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/cvilleger/geo-gouv/ci.yml?style=for-the-badge&branch=main)](https://github.com/cvilleger/geo-gouv/actions/workflows/ci.yml)
[![Packagist Version](https://img.shields.io/packagist/v/cvilleger/geo-gouv?style=for-the-badge)](https://packagist.org/packages/cvilleger/geo-gouv)
[![Packagist Downloads](https://img.shields.io/packagist/dt/cvilleger/geo-gouv?style=for-the-badge)](https://packagist.org/packages/cvilleger/geo-gouv)
[![GitHub License](https://img.shields.io/github/license/cvilleger/geo-gouv?style=for-the-badge)](https://github.com/cvilleger/geo-gouv?tab=MIT-1-ov-file#readme)

# cvilleger/geo-gouv

## About

Query geographic reference data more easily using offline data from [Gouv administrative division API](https://geo.api.gouv.fr/decoupage-administratif).

## Features

- Query all departments data
- Query all municipalities by department code

## Requirements

`cvilleger/geo-gouv` requires at least PHP 8.2

## Installation

Install this package as a dependency using [Composer](https://getcomposer.org).

``` bash
composer require cvilleger/geo-gouv
```

## Usage

### Retrieve all departments

``` php
use Cvilleger\GeoGouv\Client;

$client = new Client();

$departements = $client->getDepartements();

print_r($departements[0]);
/*
Cvilleger\GeoGouv\Model\Departement Object
(
    [nom] => Ain
    [code] => 01
    [codeRegion] => 84
    [region] => Cvilleger\GeoGouv\Model\Region Object
        (
            [nom] => Ain
            [code] => 01
        )

)
*/
```

### Retrieve all municipalities by department code

``` php
use Cvilleger\GeoGouv\Client;

$client = new Client();

$communes = $client->getCommunesByDepartementCode('01');

print_r($communes[0]);
/*
(
    [nom] => L'Abergement-Clémenciat
    [code] => 01001
    [codesPostaux] => Array
        (
            [0] => 01400
        )

    [centre] => Cvilleger\GeoGouv\Model\Centre Object
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 4.9306
                    [1] => 46.1517
                )

        )

    [surface] => 1564.5
    [population] => 832
    [departement] => Cvilleger\GeoGouv\Model\CommuneDepartement Object
        (
            [nom] => Ain
            [code] => 01
        )

    [region] => Cvilleger\GeoGouv\Model\CommuneRegion Object
        (
            [nom] => Auvergne-Rhône-Alpes
            [code] => 84
        )

)
*/
```
