<?php

declare(strict_types=1);

namespace App\Clients\Factories;

use App\Clients\DataObjects\Environment;
use App\Clients\DataObjects\Instance;
use App\Clients\DataObjects\MYSQL;
use App\Clients\DataObjects\NGINX;
use App\Clients\DataObjects\PHP;
use App\Clients\DataObjects\REDIS;
use App\Clients\DataObjects\RuntimeConfig;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class InstanceFactory
{
    /**
     * @param array $attributes
     * @return Instance
     */
    public static function make(array $attributes): Instance
    {
        return new Instance(
            id: intval(data_get($attributes, 'id')),
            name: strval(data_get($attributes, 'name')),
            runtimeDescription: strval(data_get($attributes, 'runtime_description')),
            instanceType: strval(data_get($attributes, 'instance_type')),
            description: strval(data_get($attributes, 'description')),
            runtimeConfig: new RuntimeConfig(
                php: new PHP(
                    maxUploadSizeMb: intval(data_get($attributes, 'runtime_config.php.max_upload_size_mb')),
                    fpmWorkerMemoryLimitMb: intval(data_get($attributes, 'runtime_config.php.fpm_worker_memory_limit_mb')),
                    version: strval(data_get($attributes, 'runtime_config.php.version'))
                ),
                mysql: new MYSQL(
                    enabled: boolval(data_get($attributes, 'runtime_config.mysql.enabled')),
                    version: strval(data_get($attributes, 'runtime_config.mysql.version')),
                ),
                redis: new REDIS(
                    enabled: boolval(data_get($attributes, 'runtime_config.redis.enabled'),)
                ),
                nginx: new NGINX(
                    enabled: boolval(data_get($attributes, 'runtime_config.nginx.enabled')),
                ),
            ),
            state: strval(data_get($attributes, 'state')),
            trustedSSHIps: data_get($attributes, 'trusted_ssh_ips'),
            createdAt: Carbon::parse(time: data_get($attributes, 'created_at')),
            region: strval(data_get($attributes, 'region')),
            environments: (new Collection(data_get($attributes, 'environments')))
                ->map(fn (array $environment): Environment =>
                    new Environment(
                        id: intval(data_get($environment, 'id')),
                        name: strval(data_get($environment, 'name')),
                        environmentName: strval(data_get($environment, 'environment_name')),
                        state: strval(data_get($environment, 'state')),
                        storageDirectory: strval(data_get($environment, 'storage_directory')),
                        sshEnabled: boolval(data_get($environment, 'ssh_enabled')),
                        maintenanceModeEnabledAt: Carbon::parse(
                            time: data_get($environment, 'maintenance_mode_enabled_at'),
                        ),
                        sshPort: intval(data_get($environment, 'ssh_port')),
                        appDomain: strval(data_get($environment, 'app_domain')),
                        currentDeploymentId: intval(data_get($environment, 'current_deployment_id')),
                        containerRootDirectory: strval(data_get($environment, 'container_root_directory')),
                        appType: strval(data_get($environment, 'app_type')),
                        autoDeployEnabled: intval(data_get($environment, 'auto_deploy_enabled')),
                        repoOwner: strval(data_get($environment, 'repo_owner')),
                        repoName: strval(data_get($environment, 'repo_name')),
                        branchName: strval(data_get($environment, 'branch_name')),
                        providerName: strval(data_get($environment, 'provider_name')),
                        maintenanceModeEnabled: boolval(data_get($environment, 'maintenance_mode_enabled')),
                        autoInstallComposer: intval(data_get($environment, 'auto_install_composer')),
                        webroot: strval(data_get($environment, 'webroot')),
                        appDomainEnabled: intval(data_get($environment, 'app_domain_enabled')),
                        appRoot: strval(data_get($environment, 'app_root')),
                        nginxBasicAuthEnabled: intval(data_get($environment, 'nginx_basic_auth_enabled')),
                        nginxBasicAuthUsers: data_get($environment, 'nginx_basic_auth_users'),
                        trustedIps: data_get($environment, 'trusted_ips'),
                        nodeModulesSymlink: intval(data_get($environment, 'node_modules_symlink')),
                        vendorSymlink: intval(data_get($environment, 'vendor_symlink')),
                        staticFileCache: intval(data_get($environment, 'static_file_cache')),
                        autoArtisanMigrations: intval(data_get($environment, 'auto_artisan_migrations')),
                        defaultComposerVersion: strval(data_get($environment, 'default_composer_version')),
                        autoDeployTagPatterns: data_get($environment, 'auto_deploy_tag_patterns'),
                        autoDeployBranchPatterns: data_get($environment, 'auto_deploy_branch_patterns'),
                    ),
                )->toArray(),
        );
    }
}
