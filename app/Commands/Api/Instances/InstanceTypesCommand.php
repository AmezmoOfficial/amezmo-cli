<?php

declare(strict_types=1);

namespace App\Commands\Api\Instances;

use App\Clients\DataObjects\InstanceType;
use App\Commands\AmezmoCommand;

final class InstanceTypesCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'instance-types';

    /**

     * @var string
     */
    protected $description = 'Get a list of instance types available';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info(
            string: 'Retrieving the list of instance types',
        );

        $this->table(
            headers: ['ID', 'Name', 'Hourly Price', 'Monthly Price'],
            rows: collect($this->amezmo->instanceTypes())->map(function (InstanceType $instanceType): array {
                return $instanceType->toInstanceTypesTable();
            })->all(),
        );

        return self::SUCCESS;
    }
}
