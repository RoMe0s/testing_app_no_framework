<?php

namespace App;

final class ArrayHelper
{
    public static function findValue(string $longStringKey, array $array, string $delimiter = '.')
    {
        $keyChunks = explode($delimiter, $longStringKey);
        $arrayChunk = $array;
        $isValueFound = false;

        foreach ($keyChunks as $keyChunk) {
            if (
                false === is_null($arrayChunk)
                && is_array($arrayChunk)
                && array_key_exists($keyChunk, $arrayChunk)
            ) {
                $arrayChunk = $arrayChunk[$keyChunk];
                $isValueFound = true;
            } else {
                $isValueFound = false;
            }
        }

        return $isValueFound ? $arrayChunk : null;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}