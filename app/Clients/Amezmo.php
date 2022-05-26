<?php

declare(strict_types=1);

namespace App\Clients;

use App\Clients\Collections\InstanceCollection;
use App\Clients\Collections\InstanceTypeCollection;
use App\Clients\Collections\RegionCollection;
use App\Clients\DataObjects\Instance;
use App\Clients\DataObjects\InstanceType;
use App\Clients\DataObjects\Region;
use App\Clients\Factories\InstanceFactory;
use App\Clients\Factories\InstanceTypeFactory;
use App\Clients\Factories\RegionFactory;
use App\Clients\Requests\CreateInstance;
use App\Exceptions\AmezmoApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Amezmo
{
    public function __construct(
        protected null|string $token = null,
        protected readonly string $uri = 'https://api.amezmo.com/v1',
    ) {}

    public function setApiKey(string $token): void
    {
        $this->token = $token;
    }

    public function region(string $identifier): Region
    {
        $request = $this->buildRequest();

        $response = $request->get(
            url: "regions/$identifier",
        );

        if ($response->failed()) {
            throw new AmezmoApiException(
                response: $response,
            );
        }

        return RegionFactory::make(
            attributes: $response->json(),
        );
    }

    public function regions(): RegionCollection
    {
        $request = $this->buildRequest();

        $response = $request->get(
            url: 'regions',
        );

        if ($response->failed()) {
            throw new AmezmoApiException(
                response: $response,
            );
        }

        return new RegionCollection(
            items: $response->collect()->map(fn ($region): Region =>
                RegionFactory::make(
                    attributes: $region,
                ),
            ),
        );
    }

    public function terminate(string $identifier): Instance
    {
        $request = $this->buildRequest();

        $response = $request->delete(
            url: "instances/{$identifier}"
        );

        if ($response->failed()) {
            throw new AmezmoApiException(
                response: $response,
            );
        }

        return InstanceFactory::make(
            attributes: $response->json(),
        );
    }

    public function createInstance(CreateInstance $requestData): Instance
    {
        Validator::make($requestData->toArray(), [
            'runtime' => [
                'required'
            ]
        ])->validate();

        $request = $this->buildRequest();

        $response = $request->post(
            url: 'instances',
            data: $requestData->toArray(),
        );

        if ($response->failed()) {
            throw new AmezmoApiException(
                response: $response,
            );
        }

        return InstanceFactory::make(
            attributes: $response->json(),
        );
    }

    public function instance(string $identifier): Instance
    {
        $request = $this->buildRequest();

        $response = $request->get(
            url: "instances/{$identifier}",
        );

        if ($response->failed()) {
            throw new AmezmoApiException(
                response: $response,
            );
        }

        return InstanceFactory::make(
            attributes: $response->json(),
        );
    }

    public function instanceTypes(): InstanceTypeCollection
    {
        $request = $this->buildRequest();

        $response =  $request->get(
            url: 'instance-types',
        );

        if ($response->failed()) {
            throw new AmezmoApiException(
                response: $response,
            );
        }

        return new InstanceTypeCollection(
            items: $response->collect()->map(fn ($instanceType): InstanceType =>
                InstanceTypeFactory::make(attributes: $instanceType),
            ),
        );
    }

    /**
     * @return InstanceCollection
     * @throws AmezmoApiException
     */
    public function instances(): InstanceCollection
    {
        $request = $this->buildRequest();

        $response = $request->get(
            url: '/instances',
        );

        if ($response->failed()) {
            throw new AmezmoApiException(
                response: $response,
            );
        }

        return new InstanceCollection(
            items: $response->collect()->map(fn ($instance): Instance =>
                InstanceFactory::make(attributes: $instance),
            ),
        );
    }

    public function buildRequest(): PendingRequest
    {
        return Http::baseUrl(
            url: $this->uri,
        )->withToken(
            token: $this->token,
        )->timeout(
            seconds: 15,
        )->retry(
            times: 3,
            sleepMilliseconds: 500,
        );
    }
}
