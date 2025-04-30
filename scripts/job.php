<?php

$apiGouvBaseUrl = "https://geo.api.gouv.fr";
$apiGouvDepartementsUrl = $apiGouvBaseUrl . "/departements?fields=nom,code,codeRegion,region";
$departementsFilename = "./resources/departements.json";
$communesUrlStart = $apiGouvBaseUrl . "/departements/";
$communesUrlEnd = "/communes?fields=nom,code,codesPostaux,centre,surface,population,departement,region";

// Télécharger les départements
file_put_contents($departementsFilename, file_get_contents($apiGouvDepartementsUrl));

// Lire et décoder le fichier JSON des départements
$departementsData = json_decode(file_get_contents($departementsFilename), true, 512, JSON_THROW_ON_ERROR);

// Extraire les codes des départements
$departementsCodes = array_column($departementsData, 'code');

echo "DEPARTEMENTS_CODES: " . implode(', ', $departementsCodes) . PHP_EOL;

// Télécharger les données des communes pour chaque département
foreach ($departementsCodes as $depCode) {
    echo "COMMUNE_CODE: " . $depCode . PHP_EOL;
    $communesUrl = $communesUrlStart . $depCode . $communesUrlEnd;
    $communesData = file_get_contents($communesUrl);
    $communeFilename = "./resources/commune-departement-" . $depCode . ".json";
    file_put_contents($communeFilename, $communesData);
    usleep(100000); // 0.1 seconde
}
