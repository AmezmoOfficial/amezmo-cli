<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('displayed a list of instance types', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/instance-types'),
        )
    ]);

    $this->artisan('instance-types')
        ->expectsTable(
            headers: ['ID', 'Name', 'Hourly Price', 'Monthly Price'],
            rows: fixture('amezmo/instance-types'),
        );
});
