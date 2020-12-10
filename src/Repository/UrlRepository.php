<?php

declare(strict_types=1);

namespace UrlMinifier\Repository;

use Illuminate\Database\Eloquent\Model;
use UrlMinifier\Entity\UrlEntity;

class UrlRepository
{
    /**
     * @param array $where
     *
     * @return Model|UrlEntity|null
     */
    public function findOneBy(array $where): ?UrlEntity
    {
        return UrlEntity::query()
            ->where($where)
            ->limit(1)
            ->first();
    }
}
