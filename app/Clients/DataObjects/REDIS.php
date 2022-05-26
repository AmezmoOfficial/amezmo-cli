<?php

declare(strict_types=1);

namespace App\Clients\DataObjects;

final class REDIS
{
    /**
     * @param bool $enabled
     */
    public function __construct(
        public readonly bool $enabled,
    ) {}

    /**
     * @return array<string,bool>
     */
    public function toArray(): array
    {
        return [
            'enabled' => $this->enabled,
        ];
    }
}
