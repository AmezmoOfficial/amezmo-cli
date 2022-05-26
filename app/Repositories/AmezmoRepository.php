<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Clients\Amezmo;
use App\Exceptions\InvalidToken;
use Throwable;

final class AmezmoRepository
{
    public function __construct(
        protected readonly ConfigRepository $config,
        protected Amezmo $client,
    ) {}

    public function setClient(Amezmo $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function __call(string $method, array $parameters): mixed
    {
        $this->ensureHasApiToken();

        try {
            return $this->client->{$method}(...$parameters);
        } catch (Throwable $exception) {
            throw $exception;
        }
    }

    protected function ensureHasApiToken(): void
    {
        $token = $this->config->get(
            key: 'token',
            default: $_SERVER['AMEZMO_API_TOKEN'] ?? getenv('AMEZMO_API_TOKEN') ?: null,
        );

        if (is_null($token)) {
            throw new InvalidToken(
                message: 'Please authenticate with the \'login\' command before proceeding.',
            );
        }

        $this->client->setApiKey(
            token: $token,
        );
    }
}
