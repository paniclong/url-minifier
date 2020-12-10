<?php

declare(strict_types=1);

namespace UrlMinifier\Helper\Response;

class CreatedUrlResponseHelper
{
    /**
     * @param string $uuid
     *
     * @return array
     */
    public static function fromUuid(string $uuid): array
    {
        return [
            'status' => 'created',
            'url' => ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $uuid,
        ];
    }
}
