<?php

declare(strict_types=1);

namespace App\Commands;

use App\Repositories\AmezmoRepository;
use App\Repositories\ConfigRepository;
use Illuminate\Console\Scheduling\Schedule;
use JsonException;
use LaravelZero\Framework\Commands\Command;

final class LoginCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'login {--token= : Amezmo API token}';

    /**
     * @var string
     */
    protected $description = 'Authenticate with Amezmo';

    /**
     * @param ConfigRepository $config
     * @param AmezmoRepository $amezmo
     * @return int
     * @throws JsonException
     */
    public function handle(ConfigRepository $config, AmezmoRepository $amezmo): int
    {
        $token = $this->option(
            key: 'token',
        );

        if (is_null($token)) {
            $token = $this->ask(
                question: 'What is your Amezmo API token?',
            );
        }

        $config->set(
            key: 'token',
            value: $token,
        );

        $this->info(
            string: 'Authentication credentials successfully stored.',
        );

        return self::SUCCESS;
    }

    /**
     * @param  Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
