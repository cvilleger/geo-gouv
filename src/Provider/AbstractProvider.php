<?php

declare(strict_types=1);

namespace Cvilleger\GeoGouv\Provider;

abstract class AbstractProvider
{
    private const RESOURCES_DIRECTORY = __DIR__.'/../../resources/';

    public function getArrayFromFilename(string $filename): array
    {
        $filepath = self::RESOURCES_DIRECTORY.$filename;

        $contents = file_get_contents($filepath);
        if (false === $contents) {
            throw new \RuntimeException('Unable to open file: '.$filepath);
        }

        try {
            $arrayContent = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException('Unable to parse JSON: '.$e->getMessage(), $e->getCode(), $e);
        }

        if (false === is_array($arrayContent)) {
            throw new \RuntimeException('Unable to parse JSON string: '.$filepath);
        }

        return $arrayContent;
    }
}
