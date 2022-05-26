<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('can show a specific region', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/region')
        ),
    ]);

    $this->artisan('regions:show', [
        'id' => 'au2-au'
    ])->expectsOutputToContain(
        string: 'Retrieving the region information.',
    )->expectsOutputToContain(
        string: 'au2-au',
    );
});
