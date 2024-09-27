<h1 align="center">cvilleger/geo-gouv</h1>

<p align="center">
    <strong>Simple Geo Gouv Library. Query geographic reference data more easily</strong>
</p>


<p align="center">
    <a href="https://github.com/cvilleger/geo-gouv"><img src="https://img.shields.io/badge/source-cvilleger/geo-gouv.svg?style=flat-square" alt="Source Code"></a>
    <a href="https://packagist.org/packages/cvilleger/geo-gouv"><img src="https://img.shields.io/packagist/v/cvilleger/geo-gouv.svg?style=flat-square&label=release" alt="Download Package"></a>
</p>

## About

Simple Geo Gouv Lib

## Installation

Install this package as a dependency using [Composer](https://getcomposer.org).

``` bash
composer require cvilleger/geo-gouv
```

## Usage

``` php
use Cvilleger\GeoGouv\Client;

$client = new Client();

$departements = $client->getDepartements();
$communes = $client->getCommunesByDepartementCode('01');
```
