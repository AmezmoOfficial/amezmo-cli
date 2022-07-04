<?php

declare(strict_types=1);

namespace App\Commands\Api\Environments;

use App\Clients\DataObjects\Environment;
use App\Commands\AmezmoCommand;

final class EnvironmentListCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'environments:list {id : The instance ID you wish to check.}';

    /**
     * @var string
     */
    protected $description = 'Get a list of environments for an instance.';

    /**
     * @return int
     */
    public function handle(): int
    {
        $id = $this->argument(
            key: 'id',
        );

        $this->info(
            string: "Retrieving the list of environments for instance [$id]",
        );

        $this->table(
            headers: ['ID', 'Name', 'Domain', 'Branch', "Deployment ID"],
            rows: collect($this->amezmo->environments(identifier: $id))->map(function (Environment $environment): array {
                return $environment->toEnvironmentsTable();
            })->all(),
        );

        return self::SUCCESS;
    }
}
