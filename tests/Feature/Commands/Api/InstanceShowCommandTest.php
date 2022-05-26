<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('displays a single instance', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/instance'),
        )
    ]);

    $this->artisan('instances:show 1')
        ->expectsTable(
            headers: ['ID', 'Name', 'State', 'Region'],
            rows: [
                [
                    'id' => 1,
                    'name' => 'engage-plugandplay-564192df9c',
                    'state' => 'Launching',
                    'region' => 'x-us',
                ]
            ],
        );
});
