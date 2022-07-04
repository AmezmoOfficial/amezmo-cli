<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('displayed the requested environment for an instance', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/environment'),
        )
    ]);

    $this->artisan('environments:show 123 production')
        ->expectsTable(
            headers: ['ID', 'Name', 'Domain', 'Branch', "Deployment ID"],
            rows: [
                [
                    'id' => 1608,
                    'name' => 'production',
                    'domain' => 'b9cb804b63.x.vioengine.com',
                    'branch' => 'master',
                    'deployment_id' => 10840,
                ]
            ],
        );
});
