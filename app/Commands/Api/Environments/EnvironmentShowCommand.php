<?php

declare(strict_types=1);

namespace App\Commands\Api\Environments;

use App\Clients\DataObjects\Environment;
use App\Commands\AmezmoCommand;

final class EnvironmentShowCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'environments:show
        {id : The instance ID you wish to check.}
        {name : The environment name you wish to check.}
    ';

    /**
     * @var string
     */
    protected $description = 'Show a specific environment by name.';

    /**
     * @return int
     */
    public function handle(): int
    {
        $id = $this->argument(
            key: 'id',
        );

        $name = $this->argument(
            key: 'name',
        );

        $this->info(
            string: "Retrieving the [$name] environment for instance [$id]",
        );

        $this->table(
            headers: ['ID', 'Name', 'Domain', 'Branch', "Deployment ID"],
            rows: [$this->amezmo->environment(identifier: $id, name: $name)->toEnvironmentsTable()],
        );

        return self::SUCCESS;
    }
}
