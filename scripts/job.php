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
$config['apiGouvBaseUrl'] . $config['apiGouvDepartmentsPath'] . '?' . http_build_query($config['apiGouvDepartmentsQuery'])
    |> file_get_contents(...)
    |> (fn($x) => json_decode(json: $x, associative: true, flags: JSON_THROW_ON_ERROR,))
    |> (fn($x) => json_encode(value: $x, flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,))
    |> (fn($x) => file_put_contents(filename: $config['departmentsDataFile'], data: $x,));

// Extract department codes
$departmentsCodes = $config['departmentsDataFile']
    |> file_get_contents(...)
    |> (fn($x) => json_decode(json: $x, associative: true, flags: JSON_THROW_ON_ERROR,))
    |> (fn($x) => array_column(array: $x, column_key: 'code',));

echo 'DEPARTMENTS_CODES:'.implode(', ', $departmentsCodes).PHP_EOL;

$communesUrlStart = $config['apiGouvBaseUrl'].$config['apiGouvDepartmentsPath'];
$communesUrlEnd = $config['apiGouvCommunesPath'].'?'.http_build_query($config['apiGouvCommunesQuery']);

// Retrieve and save the communes data for each department
foreach ($departmentsCodes as $departmentCode) {
    echo 'DEPARTMENT_CODE: '.$departmentCode.PHP_EOL;
    $departmentData = $config['apiGouvBaseUrl'] . $config['apiGouvDepartmentsPath'] . '/' . $departmentCode . $communesUrlEnd
        |> file_get_contents(...)
        |> (fn($x) => json_decode(json: $x, associative: true, flags: JSON_THROW_ON_ERROR,))
        |> (fn($x) => json_encode(value: $x, flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,));
    file_put_contents(
        filename: sprintf($config['communesDataFilePattern'], $departmentCode),
        data: $departmentData,
    );
    usleep(100000); // 0.1 second
}
