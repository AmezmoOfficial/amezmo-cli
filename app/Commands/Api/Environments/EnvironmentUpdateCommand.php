<?php

declare(strict_types=1);

namespace App\Commands\Api\Environments;

use App\Clients\Factories\EnvironmentFactory;
use App\Clients\Requests\UpdateEnvironment;
use App\Commands\AmezmoCommand;
use Throwable;

final class EnvironmentUpdateCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'environments:update
        {id : The instance ID you wish to check.}
        {name : The environment name you wish to check.}
    ';

    /**
     * @var string
     */
    protected $description = 'Update an environment by instance ID and environment name.';

    /**
     * @return int
     */
    public function handle(): int
    {
        $id = $this->argument(
            key: 'id',
        );
        $name = $this->argument(
            key: 'name',
        );

        $environment = new UpdateEnvironment(
            autoDeployTagPatterns: $this->ask(
                question: 'What auto deployment tag pattern (regex) do you want to use?',
                default: null,
            ),
            autoDeployBranchPatterns: $this->ask(
                question: 'What auto deployment branch pattern (regex) do you want to use?',
                default: null,
            ),
            newRelicLicenseKey: $this->ask(
                question: 'Enter your New Relic API Key if you have one.',
                default: null,
            ),
            sshEnabled: $this->confirm(
                question: 'Do you want SSH to be enabled?',
                default: false,
            ),
            trustedIps: $this->trustedIps(),
        );

        $this->info(
            string: "Requesting Environment [$name] to be updated for instance [$id]."
        );

        try {
            $response = $this->amezmo->updateEnvironment(
                environment: $environment,
                id: $id,
                name: $name,
            );
        } catch (Throwable $exception) {
            $this->error(
                string: $exception->getMessage(),
            );

            return self::FAILURE;
        }

        $environment = EnvironmentFactory::make(
            attributes: $response->toArray(),
        );

        $this->table(
            headers: ['ID', 'Name', 'Domain', 'Branch', "Deployment ID"],
            rows: [$environment->toEnvironmentsTable()],
        );

        return self::SUCCESS;
    }

    protected function trustedIps(): null|array
    {
        $answer = $this->ask(
            question: 'Enter a comma separated list of trusted IP addresses.',
            default: null,
        );

        if (null === $answer) {
            return null;
        }

        return explode(
            separator: ',',
            string: $answer,
        );
    }
}
