[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/cvilleger/geo-gouv/ci.yml?style=for-the-badge&branch=main)](https://github.com/cvilleger/geo-gouv/actions/workflows/ci.yml)
[![Packagist Version](https://img.shields.io/packagist/v/cvilleger/geo-gouv?style=for-the-badge)](https://packagist.org/packages/cvilleger/geo-gouv)
[![Packagist Downloads](https://img.shields.io/packagist/dt/cvilleger/geo-gouv?style=for-the-badge)](https://packagist.org/packages/cvilleger/geo-gouv)
[![GitHub License](https://img.shields.io/github/license/cvilleger/geo-gouv?style=for-the-badge)](https://github.com/cvilleger/geo-gouv?tab=MIT-1-ov-file#readme)

# cvilleger/geo-gouv

Client PHP léger pour interroger des données de référence géographiques françaises (dumps hors-ligne basés sur l'API officielle de l'État : https://geo.api.gouv.fr/decoupage-administratif).

## Fonctionnalités

- Récupération de la liste des départements
- Récupération des communes d'un département
- Modèles PHP pour les entités (Département, Région, Commune)
- Aucun package externe requis (zéro dépendance Composer)

## Exigences

- PHP 8.5 ou supérieur

## Installation

Installer via Composer :

```bash
composer require cvilleger/geo-gouv
```

## Utilisation

Récupérer les départements :

```php
use Cvilleger\GeoGouv\Client;

print_r(new Client()->getDepartements()[0]);

/*
Cvilleger\GeoGouv\Model\Departement Object
(
    [nom] => Ain
    [code] => 01
    [codeRegion] => 84
    [coordinates] => 46.06551335, 5.28478031423462
    [region] => Cvilleger\GeoGouv\Model\Region Object
        (
            [nom] => Auvergne-Rhône-Alpes
            [code] => 84
        )

)
*/
```

Récupérer les communes d'un département (ex. `01`) :

```php
use Cvilleger\GeoGouv\Client;

print_r(new Client()->getCommunesByDepartementCode('01')[0]);

/*
(
    [nom] => L'Abergement-Clémenciat
    [code] => 01001
    [codesPostaux] => Array
        (
            [0] => 01400
        )

    [coordinates] => Array
        (
            [0] => 4.9306
            [1] => 46.1517
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

## Données et mises à jour

Les données proviennent de l'API publique `geo.api.gouv.fr`. Mettre à jour régulièrement la librairie pour refléter les changements administratifs.

## Licence

MIT — voir le fichier LICENSE.
