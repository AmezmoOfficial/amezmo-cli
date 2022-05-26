<?php

declare(strict_types=1);

namespace App\Commands\Api\Regions;

use App\Commands\AmezmoCommand;

final class RegionShowCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'regions:show {id : The region ID you want to see.}';

    /**
     * @var string
     */
    protected $description = 'Show the information about a specific region.';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info(
            string: 'Retrieving the region information.',
        );

        $region = $this->amezmo->region(
            identifier: $this->argument(key: 'id'),
        );

        $this->table(
            headers: ['ID', 'Name', 'ISO Country Code'],
            rows: [
                [
                    'id' => $region->id,
                    'name' => $region->name,
                    'iso_country_code' => $region->iso,
                ]
            ],
        );

        return self::SUCCESS;
    }
}
