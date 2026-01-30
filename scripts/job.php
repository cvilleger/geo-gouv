<?php

$config = [
    'apiGouvBaseUrl' => 'https://geo.api.gouv.fr',
    'apiGouvDepartmentsPath' => '/departements',
    'apiGouvDepartmentsQuery' => [
        'fields' => 'nom,code,codeRegion,region',
    ],
    'apiGouvCommunesPath' => '/communes',
    'apiGouvCommunesQuery' => [
        'fields' => 'nom,code,codesPostaux,centre,surface,population,departement,region',
    ],
    'departmentsDataFile' => './resources/departments.json',
    'communesDataFilePattern' => './resources/department-%s.json',
];

// Retrieve and save the departments data
file_put_contents(
    filename: $config['departmentsDataFile'],
    data: file_get_contents(
        filename: $config['apiGouvBaseUrl'].$config['apiGouvDepartmentsPath'].'?'.http_build_query($config['apiGouvDepartmentsQuery']),
    ),
);

// Read and decode the JSON file of departments
$departmentsData = json_decode(
    json: file_get_contents(
        filename: $config['departmentsDataFile'],
    ),
    associative: true,
    flags: JSON_THROW_ON_ERROR,
);

// Extract department codes
$departmentsCodes = array_column(
    array: $departmentsData,
    column_key: 'code',
);

echo 'DEPARTMENTS_CODES:'.implode(', ', $departmentsCodes).PHP_EOL;

$communesUrlStart = $config['apiGouvBaseUrl'].$config['apiGouvDepartmentsPath'];
$communesUrlEnd = $config['apiGouvCommunesPath'].'?'.http_build_query($config['apiGouvCommunesQuery']);

// Retrieve and save the communes data for each department
foreach ($departmentsCodes as $departmentCode) {
    echo 'DEPARTMENT_CODE: '.$departmentCode.PHP_EOL;
    $communesUrl = $config['apiGouvBaseUrl'].$config['apiGouvDepartmentsPath'].'/'.$departmentCode.$communesUrlEnd;
    $communesData = file_get_contents($communesUrl);
    $communeFilename = sprintf($config['communesDataFilePattern'], $departmentCode);
    file_put_contents($communeFilename, $communesData);
    usleep(100000); // 0.1 seconde
}
