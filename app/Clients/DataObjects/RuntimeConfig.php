<?php

declare(strict_types=1);

namespace App\Clients\DataObjects;

final class RuntimeConfig
{
    /**
     * @param PHP $php
     * @param MYSQL $mysql
     * @param REDIS $redis
     * @param NGINX $nginx
     */
    public function __construct(
        public readonly PHP $php,
        public readonly MYSQL $mysql,
        public readonly REDIS $redis,
        public readonly NGINX $nginx,
    ) {}

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'php' => $this->php->toArray(),
            'mysql' => $this->mysql->toArray(),
            'redis' => $this->redis->toArray(),
            'nginx' => $this->nginx->toArray(),
        ];
    }
}
