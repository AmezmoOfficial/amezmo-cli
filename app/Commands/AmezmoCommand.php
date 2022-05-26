<?php

declare(strict_types=1);

namespace App\Commands;

use App\Repositories\AmezmoRepository;
use App\Repositories\ConfigRepository;
use Closure;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AmezmoCommand extends Command
{
    protected static Closure|null $latestVersionResolver = null;

    public function __construct(
        protected readonly ConfigRepository $config,
        protected readonly AmezmoRepository $amezmo,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return tap(parent::execute(input: $input, output: $output), fn () =>
            $this->ensureLatestVersion(),
        );
    }

    protected function ensureLatestVersion(): void
    {
        $current = 'v'. config(key: 'app.version');

        if (version_compare(version1: $remote = $this->getLatestVersion(), version2: $current ) > 0) {
            $this->warn(
                string: "You are using an outdated version $current of the Amezmo CLI. Please update to $remote.",
            );
        }
    }

    protected function getLatestVersion(): string
    {
        $resolver = static::$latestVersionResolver ?? static function () {
            $package = json_decode(
                json: file_get_contents(
                    filename: 'https://packagist.org/p2/juststeveking/amezmo-cli.json',
                ),
                associative: true,
                depth: 512,
                flags: JSON_THROW_ON_ERROR,
            );

            return collect($package['packages']['juststeveking/amezmo-cli'])
                ->first()['version'];
        };

        if (is_null($this->config->get(key: 'latest_version_verified_at'))) {
            $this->config->set(
                key: 'latest_version_verified_at',
                value: now()->timestamp,
            );
        }

        if (is_null($this->config->get(key: 'latest_version'))) {
            $this->config->set(
                key:   'latest_version',
                value: $resolver(),
            );
        }

        if ($this->config->get(key: 'latest_version_verified_at') < now()->subDays()->timestamp) {
            $this->config->set(
                key:   'latest_version',
                value: $resolver(),
            );

            $this->config->set(
                key:   'latest_version_verified_at',
                value: now()->timestamp,
            );
        }

        return $this->config->get(
            key: 'latest_version',
        );
    }

    public static function resolveLatestVersionUsing(Closure $resolver): void
    {
        static::$latestVersionResolver = $resolver;
    }
}
