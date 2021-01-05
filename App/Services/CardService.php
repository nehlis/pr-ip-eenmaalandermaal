<?php

namespace App\Services;

/**
 * Class CardService
 * @package App\Services
 */
class CardService
{
    /**
     * Gets the thumbnail for the card
     * @param   string  $path   The path to use as a thumbnail
     * @return  string          The image path to use as a thumbnail
     */
    public static function getThumbnail(string $path): string
    {
        return $path == REMOTE_URL
            || $path == REMOTE_URL . "/thumbnails/"
            || $path == NULL
            ? PLACEHOLDER
            : $path;
    }
}
