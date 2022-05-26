<?php

declare(strict_types=1);

namespace App\Clients\Requests;

final class CreateInstance
{
    public function __construct(
        public readonly string $runtime,
        public readonly string $instanceType,
        public readonly string $region,
        public readonly null|string $name = null,
        public readonly null|string $domain = null,
        public readonly null|string $phpVersion = null,
        public readonly null|string $composerVersion = null,
        public readonly null|string $mySqlVersion = null,
        public readonly null|bool $mysqlEnabled = null,
        public readonly null|string $databaseName = null,
        public readonly null|string $databaseUser = null,
        public readonly null|string $databasePassword = null,
    ) {}

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'runtime' => $this->runtime,
            'instance_type' => $this->instanceType,
            'region' => $this->region,
            'name' => $this->name,
            'domain' => $this->domain,
            'php' => [
                'version' => $this->phpVersion,
                'composer_version' => $this->composerVersion,
            ],
            'mysql' => [
                'version' => $this->mySqlVersion,
                'enabled' => $this->mysqlEnabled,
                'database' => [
                    'name' => $this->databaseName,
                    'user' => $this->databaseUser,
                    'password' => $this->databasePassword,
                ]
            ],
        ];
    }
}
