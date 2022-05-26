<?php

declare(strict_types=1);

namespace App\Clients\DataObjects;

final class InstanceType
{
    /**
     * @param string $id
     * @param string $name
     * @param string $hourlyPrice
     * @param int $monthlyPrice
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $hourlyPrice,
        public readonly int $monthlyPrice,
    ) {}

    /**
     * @return array<string,string|int>
     */
    public function toInstanceTypesTable(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'hourly_price' => $this->hourlyPrice,
            'monthly_price' => $this->monthlyPrice,
        ];
    }
}
