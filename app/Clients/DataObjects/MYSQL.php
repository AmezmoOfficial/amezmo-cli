<?php

declare(strict_types=1);

namespace App\Clients\DataObjects;

final class MYSQL
{
    /**
     * @param bool $enabled
     * @param string $version
     */
    public function __construct(
        public readonly bool $enabled,
        public readonly string $version,
    ) {}

    /**
     * @return array<string,string|bool>
     */
    public function toArray(): array
    {
        return [
            'enabled' => $this->enabled,
            'version' => $this->version,
        ];
    }
}
