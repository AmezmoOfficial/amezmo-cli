<?php

declare(strict_types=1);

namespace App\Clients\Factories;

use App\Clients\DataObjects\Environment;
use Illuminate\Support\Carbon;

final class EnvironmentFactory
{
    public static function make(array $attributes): Environment
    {
        return new Environment(
            id: intval(data_get($attributes, 'id')),
            name: strval(data_get($attributes, 'name')),
            environmentName: strval(data_get($attributes, 'environment_name')),
            state: strval(data_get($attributes, 'state')),
            storageDirectory: strval(data_get($attributes, 'storage_directory')),
            sshEnabled: boolval(data_get($attributes, 'ssh_enabled')),
            maintenanceModeEnabledAt: Carbon::parse(
                time: data_get($attributes, 'maintenance_mode_enabled_at'),
            ),
            sshPort: intval(data_get($attributes, 'ssh_port')),
            appDomain: strval(data_get($attributes, 'app_domain')),
            currentDeploymentId: intval(data_get($attributes, 'current_deployment_id')),
            containerRootDirectory: strval(data_get($attributes, 'container_root_directory')),
            appType: strval(data_get($attributes, 'app_type')),
            autoDeployEnabled: intval(data_get($attributes, 'auto_deploy_enabled')),
            repoOwner: strval(data_get($attributes, 'repo_owner')),
            repoName: strval(data_get($attributes, 'repo_name')),
            branchName: strval(data_get($attributes, 'branch_name')),
            providerName: strval(data_get($attributes, 'provider_name')),
            maintenanceModeEnabled: boolval(data_get($attributes, 'maintenance_mode_enabled')),
            autoInstallComposer: intval(data_get($attributes, 'auto_install_composer')),
            webroot: strval(data_get($attributes, 'web_root')),
            appDomainEnabled: intval(data_get($attributes, 'app_domain_enabled')),
            appRoot: strval(data_get($attributes, 'app_root')),
            nginxBasicAuthEnabled: intval(data_get($attributes, 'nginx_basic_auth_enabled')),
            nginxBasicAuthUsers: (array) data_get($attributes, 'nginx_basic_auth_users'),
            trustedIps: (array) data_get($attributes, 'trusted_ips'),
            nodeModulesSymlink: intval(data_get($attributes, 'node_modules_symlink')),
            vendorSymlink: intval(data_get($attributes, 'vendor_symlink')),
            staticFileCache: intval(data_get($attributes, 'static_file_cache')),
            autoArtisanMigrations: intval(data_get($attributes, 'auto_artisan_migrations')),
            defaultComposerVersion: strval(data_get($attributes, 'default_composer_version')),
            autoDeployTagPatterns: (array) data_get($attributes, 'auto_deploy_tag_patterns'),
            autoDeployBranchPatterns: (array) data_get($attributes, 'auto_deploy_branch_patterns'),
        );
    }
}
