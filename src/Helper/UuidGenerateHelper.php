<?php

declare(strict_types=1);

namespace UrlMinifier\Helper;

use Exception;

class UuidGenerateHelper
{
    /**
     * @param int $length
     *
     * @return string
     *
     * @throws Exception
     */
    public static function generate($length = 8): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
