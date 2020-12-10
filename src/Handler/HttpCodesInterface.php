<?php

declare(strict_types=1);

namespace UrlMinifier\Handler;

interface HttpCodesInterface
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;

    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_NOT_FOUND = 404;
}
