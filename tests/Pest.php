<?php

declare(strict_types=1);

use App\Clients\Amezmo;
use App\Commands\AmezmoCommand;
use App\Repositories\AmezmoRepository;
use App\Repositories\ConfigRepository;
use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function ():void {
        (new Filesystem)->deleteDirectory(
            directory: base_path(
                path: 'tests/.amezmo',
            ),
        );

        $this->config = resolve(
            name: ConfigRepository::class,
        )->set(
            key: 'token',
            value: '123123123',
        );

        $this->amezmo = resolve(
            name: AmezmoRepository::class,
        );

        AmezmoCommand::resolveLatestVersionUsing(static function (): string {
            return strval(config('app.version'));
        });
    })->afterEach(function () {
        (new Filesystem)->deleteDirectory(
            directory: base_path(
                path: 'tests/.amezmo',
            ),
        );
    })->in('Feature', 'Unit');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function fixture(string $name): array
{
    $file = file_get_contents(
        filename: base_path("tests/Fixtures/$name.json"),
    );

    if(! $file) {
        throw new InvalidArgumentException(
            message: "Cannot find fixture: [$name] at tests/Fixtures/$name.json",
        );
    }

    return json_decode(
        json: $file,
        associative: true,
    );
}
