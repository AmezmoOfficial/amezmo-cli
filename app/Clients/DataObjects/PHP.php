<?php

declare(strict_types=1);

namespace App\Clients\DataObjects;

final class PHP
{
    /**
     * @param int $maxUploadSizeMb
     * @param int $fpmWorkerMemoryLimitMb
     * @param string $version
     */
    public function __construct(
        public readonly int $maxUploadSizeMb,
        public readonly int $fpmWorkerMemoryLimitMb,
        public readonly string $version,
    ) {}

    /**
     * @return array<string,string|int>
     */
    public function toArray(): array
    {
        return [
            'max_upload_size_mb' => $this->maxUploadSizeMb,
            'fpm_worker_memory_limit_mb' => $this->fpmWorkerMemoryLimitMb,
            'version' => $this->version,
        ];
    }
}
