<?php

declare(strict_types=1);

namespace App\Clients\DataObjects;

final class Region
{
    /**
     * @param string $id
     * @param string $iso
     * @param string $name
     */
    public function __construct(
        public readonly string $id,
        public readonly string $iso,
        public readonly string $name,
    ) {}

    /**
     * @return array<string,string>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'iso_country_code' => $this->iso,
            'name' => $this->name,
        ];
    }
}
