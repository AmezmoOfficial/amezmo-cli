<?php

declare(strict_types=1);

namespace App\Commands\Api;

use App\Commands\AmezmoCommand;
use Throwable;

final class InstanceTerminateCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'instances:delete {id : The ID of the instance.}';

    /**
     * @var string
     */
    protected $description = 'Queue an instance for termination.';

    /**
     * @return int
     */
    public function handle(): int
    {
        try {
            $instance = $this->amezmo->terminate(
                identifier: $this->argument('id'),
            );
        } catch (Throwable $exception) {
            $this->error(
                string: $exception->getMessage(),
            );

            return self::FAILURE;
        }

        $this->info(
            string: "Instance has been queued for termination.",
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
