<?php

declare(strict_types=1);

namespace App\Clients\Factories;

use App\Clients\DataObjects\Region;

final class RegionFactory
{
    /**
     * @param array $attributes
     * @return Region
     */
    public static function make(array $attributes): Region
    {
        return new Region(
            id: strval(data_get($attributes, 'id')),
            iso: strval(data_get($attributes, 'iso_country_code')),
            name: strval(data_get($attributes, 'name')),
        );
    }
}
