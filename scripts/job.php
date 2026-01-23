<?php

$apiGouvBaseUrl = "https://geo.api.gouv.fr";
$apiGouvDepartmentsUrl = $apiGouvBaseUrl . "/departements?fields=nom,code,codeRegion,region";
$departmentsFilename = "./resources/departments.json";
$municipalitiesUrlStart = $apiGouvBaseUrl . "/departements/";
$municipalitiesUrlEnd = "/communes?fields=nom,code,codesPostaux,centre,surface,population,departement,region";

// Retrive departments data from API and save to local file
file_put_contents($departmentsFilename, file_get_contents($apiGouvDepartmentsUrl));

// Read and decode the JSON file of departments
$departmentsData = json_decode(file_get_contents($departmentsFilename), true, 512, JSON_THROW_ON_ERROR);

// Extract department codes
$departmentsCodes = array_column($departmentsData, 'code');

echo "DEPARTMENTS_CODES: " . implode(', ', $departmentsCodes) . PHP_EOL;

// Retrive municipalities data for each department and save to local files
foreach ($departmentsCodes as $departmentCode) {
    echo "DEPARTMENT_CODES: " . $departmentCode . PHP_EOL;
    $municipalitiesUrl = $municipalitiesUrlStart . $departmentCode . $municipalitiesUrlEnd;
    $municipalitiesData = file_get_contents($municipalitiesUrl);
    $municipalityFilename = "./resources/department-" . $departmentCode . ".json";
    file_put_contents($municipalityFilename, $municipalitiesData);
    usleep(100000); // 0.1 seconde
}
