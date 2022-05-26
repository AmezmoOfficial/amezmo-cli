<?php

declare(strict_types=1);

namespace App\Commands\Api\Instances;

use App\Clients\DataObjects\Instance;
use App\Commands\AmezmoCommand;

;

final class InstancesListCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'instances:list';

    /**
     * @var string
     */
    protected $description = 'Get a list of instances.';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info(
            string: 'Retrieving the list of instances',
        );

        $this->table(
            headers: ['ID', 'Name', 'State', 'Region'],
            rows: collect($this->amezmo->instances())->map(function (Instance $instance): array {
                return $instance->toInstancesTable();
            })->all(),
        );

        return self::SUCCESS;
    }
}
