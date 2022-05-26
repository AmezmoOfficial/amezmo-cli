<?php

declare(strict_types=1);

namespace App\Commands\Api\Regions;

use App\Clients\DataObjects\Region;
use App\Commands\AmezmoCommand;
use Throwable;

final class RegionListCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'regions:list';

    /**
     * @var string
     */
    protected $description = 'Get a list of available regions from the API.';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info(
            string: 'Retreiving data from API.',
        );

        try {
            $regions = $this->amezmo->regions();
        } catch (Throwable $exception) {
            $this->error(
                string: $exception->getMessage(),
            );

            return self::FAILURE;
        }

        $this->table(
            headers: ['ID', 'Name', 'ISO Country Code'],
            rows: collect($regions)->map(fn (Region $region): array =>
                $region->toArray(),
            )->all(),
        );

        return self::SUCCESS;
    }
}
