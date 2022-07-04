<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('displays a single instance', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/environment-update'),
        )
    ]);

    $this
        ->artisan(command: 'environments:update 123 production')
        ->expectsQuestion(
            question: 'What auto deployment tag pattern (regex) do you want to use?',
            answer: null,
        )->expectsQuestion(
            question: 'What auto deployment branch pattern (regex) do you want to use?',
            answer: null,
        )->expectsQuestion(
            question: 'Enter your New Relic API Key if you have one.',
            answer: null,
        )->expectsQuestion(
            question: 'Do you want SSH to be enabled?',
            answer: true,
        )->expectsQuestion(
            question: 'Enter a comma separated list of trusted IP addresses.',
            answer: null,
        )->expectsOutputToContain(
            string: 'Requesting Environment [production] to be updated for instance [123].'
        );
});
