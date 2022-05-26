<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('can get a list of regions', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/regions'),
        )
    ]);

    $this->artisan(
        command: 'regions:list',
    )->expectsTable(
        headers: ['ID', 'Name', 'ISO Country Code'],
        rows: fixture('amezmo/regions')
    );
});
