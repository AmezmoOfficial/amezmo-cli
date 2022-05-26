<?php

declare(strict_types=1);

namespace App\Clients\DataObjects;

use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Password;

final class Instance
{
    /**
     * @param int $id
     * @param string $name
     * @param string $runtimeDescription
     * @param string $instanceType
     * @param string|null $description
     * @param RuntimeConfig $runtimeConfig
     * @param string $state
     * @param array $trustedSSHIps
     * @param Carbon $createdAt
     * @param string $region
     * @param array<int,Environment> $environments
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $runtimeDescription,
        public readonly string $instanceType,
        public readonly null|string $description,
        public readonly RuntimeConfig $runtimeConfig,
        public readonly string $state,
        public readonly array $trustedSSHIps,
        public readonly Carbon $createdAt,
        public readonly string $region,
        public readonly array $environments,
    ) {}

    /**
     * @return array<string,int|string>
     */
    public function toInstancesTable(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'state' => $this->state,
            'region' => $this->region,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'runtime_description' => $this->runtimeDescription,
            'instance_type' => $this->instanceType,
            'description' => $this->description,
            'runtime_config' => $this->runtimeConfig->toArray(),
            'state' => $this->state,
            'trusted_ssh_ips' => $this->trustedSSHIps,
            'created_at' => $this->createdAt->toDateTimeString(),
            'region' => $this->region,
            'environments' => (new Collection(
                items: $this->environments,
            ))->map(fn (Environment $environment): array => $environment->toArray())->toArray(),
        ];
    }

    public static function validationRules(array $data = []): array
    {
        return [
            'runtime' => [
                'required',
                'string',
                'in:php,mysql',
            ],
            'instance_type' => [
                'required',
                'string',
                'in:hobby,developer,business',
            ],
            'region' => [
                'required',
                'string',
                'in:lb2-us,au2-au,uk3-uk,ca-ca',
            ],
            'name' => [
                'nullable',
                'string',
            ],
            'domain' => [
                'nullable',
                'url',
            ],
            'php' => [
                Rule::requiredif($data['runtime'] === 'php'),
            ],
            'php.version' => [
                Rule::requiredif($data['runtime'] === 'php'),
                'string',
            ],
            'php.composer_version' => [
                Rule::requiredif($data['runtime'] === 'php'),
                'in:1,2',
            ],
            'mysql' => [
                'nullable',
            ],
            'mysql.version' => [
                Rule::requiredif(! is_null($data['mysql'])),
                'in:5.7,8',
            ],
            'mysql.enabled' => [
                Rule::requiredif(! is_null($data['mysql'])),
                'boolean',
            ],
            'mysql.database' => [
                Rule::requiredif(! is_null($data['mysql'])),
            ],
            'mysql.database.name' => [
                Rule::requiredif(! is_null($data['mysql'])),
                'string',
            ],
            'mysql.database.user' => [
                Rule::requiredif(! is_null($data['mysql'])),
                'string',
            ],
            'mysql.database.password' => [
                Rule::requiredif(! is_null($data['mysql'])),
                'string',
                Password::defaults(),
            ]
        ];
    }
}
