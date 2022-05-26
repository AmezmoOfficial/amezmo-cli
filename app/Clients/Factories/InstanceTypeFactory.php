<?php

declare(strict_types=1);

namespace App\Clients\Factories;

use App\Clients\DataObjects\InstanceType;

final class InstanceTypeFactory
{
    /**
     * @param array<string,mixed> $attributes
     * @return InstanceType
     */
    public static function make(array $attributes): InstanceType
    {
        return new InstanceType(
            id: strval(data_get($attributes, 'id')),
            name: strval(data_get($attributes, 'name')),
            hourlyPrice: strval(data_get($attributes, 'hourly_price')),
            monthlyPrice: intval(data_get($attributes, 'monthly_price'))
        );
    }
}
