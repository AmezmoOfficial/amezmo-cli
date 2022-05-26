<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('queues an instance to be terminated', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/instance-terminate'),
        ),
    ]);

    $this->artisan(
        command: 'instances:delete 123',
    )->expectsTable(
        headers: ['ID', 'Name', 'State', 'Region'],
        rows: [
            [
                'id' => 1,
                'name' => 'engage-plugandplay-564192df9c',
                'state' => 'Deleting',
                'region' => 'x-us',
            ]
        ],
    )->expectsOutputToContain(
        string: 'Instance has been queued for termination.',
    );
});
