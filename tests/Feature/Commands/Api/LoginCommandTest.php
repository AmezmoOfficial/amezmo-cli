<?php

declare(strict_types=1);

beforeEach(fn () =>
    $this->config->flush(),
);

it('authenticates users', function () {
    expect(
        $this->config->get('token'),
    )->toBeNull();

    $this->artisan('login --token=123123123')
        ->assertSuccessful();

    expect(
        $this->config->get('token'),
    )->toBeString()->toEqual('123123123');
});
