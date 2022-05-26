<?php

declare(strict_types=1);

namespace App\Commands\Api;

use App\Clients\Factories\InstanceFactory;
use App\Clients\Requests\CreateInstance;
use App\Commands\AmezmoCommand;
use Throwable;

final class InstanceCreateCommand extends AmezmoCommand
{
    /**
     * @var string
     */
    protected $signature = 'instances:create';

    /**
     * @var string
     */
    protected $description = 'Create a new Instance.';

    /**
     * @return int
     */
    public function handle(): int
    {
        $instance = new CreateInstance(
            runtime: $this->choice(
                question: "What runtime do you want to use?",
                choices: ['php', 'mysql'],
            ),
            instanceType: $this->choice(
                question: 'Which instance type do you want to use?',
                choices: ['hobby', 'developer', 'business'],
            ),
            region: $this->choice(
                question: 'Which region do you want to use?',
                choices: ['lb2-us', 'au2-au', 'uk3-uk', 'ca-ca'],
            ),
            name: $this->ask(
                question: 'What name do you want to use?',
                default: null,
            ),
            domain: $this->ask(
                question: 'What domain do you want to use?',
                default: null,
            ),
            phpVersion: $this->ask(
                question: 'Which PHP version do you want to use?',
                default: null,
            ),
            composerVersion: $this->choice(
                question: 'Which composer version do you want to use?',
                choices: ['default', '1', '2'],
                default: null,
            ),
            mySqlVersion: $this->choice(
                question: 'Which MySQL version do you want to use?',
                choices: ['none', '5.7', '8'],
                default: null,
            ),
            mysqlEnabled: $this->confirm(
                question: 'Do you want to enable MySQL?',
                default: false,
            ),
            databaseName: $this->ask(
                question: 'What name do you want to give your database?',
                default: null,
            ),
            databaseUser: $this->ask(
                question: 'What user do you want to create for this database?',
                default: null,
            ),
            databasePassword: $this->ask(
                question: "What password fo you want to use?",
                default: null,
            ),
        );

        try {
            $response = $this->amezmo->createInstance(
                instance: $instance,
            );
        } catch (Throwable $exception) {
            $this->error(
                string: $exception->getMessage(),
            );

            return self::FAILURE;
        }

        $instance = InstanceFactory::make(
            attributes: $response->toArray(),
        );

        $this->table(
            headers: ['ID', 'Name', 'State', 'Region'],
            rows: [
                [
                    'id' => $instance->id,
                    'name' => $instance->name,
                    'state' => $instance->state,
                    'region' => $instance->region,
                ]
            ],
        );

        return self::SUCCESS;
    }
}
