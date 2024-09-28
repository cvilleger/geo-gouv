<h1 align="center">cvilleger/geo-gouv</h1>

<p align="center">
    <strong>Simple Geo Gouv Library.</strong>
</p>


<p align="center">
    <a href="https://github.com/cvilleger/geo-gouv"><img src="https://img.shields.io/badge/source-cvilleger/geo-gouv.svg?style=flat-square" alt="Source Code"></a>
    <a href="https://packagist.org/packages/cvilleger/geo-gouv"><img src="https://img.shields.io/packagist/v/cvilleger/geo-gouv.svg?style=flat-square" alt="Download Package"></a>
    <a href="https://github.com/cvilleger/geo-gouv/actions/workflows/ci.yml"><img src="https://img.shields.io/github/actions/workflow/status/cvilleger/geo-gouv/ci.yml?style=flat-square" alt="Build Status"></a>
    <img alt="GitHub License" src="https://img.shields.io/github/license/cvilleger/geo-gouv?style=flat-square">
</p>

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

``` php
use Cvilleger\GeoGouv\Client;

$client = new Client();

$departements = $client->getDepartements();
$communes = $client->getCommunesByDepartementCode('01');
```
