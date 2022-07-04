<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('displayed the list of environments for an instance', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/environments'),
        )
    ]);

    $this->artisan('environments:list 1')
        ->expectsOutputToContain(
            string: 'production.example.com',
        )->expectsOutputToContain(
            string: 'staging.example.com',
        );
});
