<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('displayed the list of instances', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/instances'),
        )
    ]);

    $this->artisan('instances:list')
        ->expectsTable(
            headers: ['ID', 'Name', 'State', 'Region'],
            rows: [
                [
                    'id' => 1,
                    'name' => 'engage-plugandplay-564192df9c',
                    'state' => 'Launching',
                    'region' => 'x-us'
                ]
            ],
        );
});
