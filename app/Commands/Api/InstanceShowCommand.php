<?php

declare(strict_types=1);

namespace App\Commands\Api;

use App\Clients\Factories\InstanceFactory;
use App\Commands\AmezmoCommand;

final class InstanceShowCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'instances:show {id : The ID of the instance.}';

    /**
     * @var string
     */
    protected $description = 'Get a specific Instance from the API.';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info(
            string: 'Retrieving the instance',
        );

        $instance = InstanceFactory::make(
            attributes: $this->amezmo->instance(
                identifier: $this->argument(key: 'id'),
            )->toArray(),
        );

        $this->table(
            headers: ['ID', 'Name', 'State', 'Region'],
            rows: [
                [
                    'id' => $instance->id,
                    'name' => $instance->name,
                    'state' => $instance->state,
                    'region' => $instance->region,
                ]
            ],
        );

        return self::SUCCESS;
    }
}
