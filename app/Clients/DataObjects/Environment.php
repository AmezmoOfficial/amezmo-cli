<?php

declare(strict_types=1);

namespace App\Clients\DataObjects;

use Illuminate\Support\Carbon;

final class Environment
{
    /**
     * @param int $id
     * @param string $name
     * @param string $environmentName
     * @param string $state
     * @param string $storageDirectory
     * @param bool $sshEnabled
     * @param Carbon|null $maintenanceModeEnabledAt
     * @param int $sshPort
     * @param string $appDomain
     * @param int $currentDeploymentId
     * @param string $containerRootDirectory
     * @param string $appType
     * @param int $autoDeployEnabled
     * @param string $repoOwner
     * @param string $repoName
     * @param string $branchName
     * @param string $providerName
     * @param bool $maintenanceModeEnabled
     * @param int $autoInstallComposer
     * @param string $webroot
     * @param int $appDomainEnabled
     * @param string $appRoot
     * @param int $nginxBasicAuthEnabled
     * @param array $nginxBasicAuthUsers
     * @param array $trustedIps
     * @param int $nodeModulesSymlink
     * @param int $vendorSymlink
     * @param int $staticFileCache
     * @param int $autoArtisanMigrations
     * @param string $defaultComposerVersion
     * @param array $autoDeployTagPatterns
     * @param array $autoDeployBranchPatterns
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $environmentName,
        public readonly string $state,
        public readonly string $storageDirectory,
        public readonly bool $sshEnabled,
        public readonly null|Carbon $maintenanceModeEnabledAt,
        public readonly int $sshPort,
        public readonly string $appDomain,
        public readonly int $currentDeploymentId,
        public readonly string $containerRootDirectory,
        public readonly string $appType,
        public readonly int $autoDeployEnabled,
        public readonly string $repoOwner,
        public readonly string $repoName,
        public readonly string $branchName,
        public readonly string $providerName,
        public readonly bool $maintenanceModeEnabled,
        public readonly int $autoInstallComposer,
        public readonly string $webroot,
        public readonly int $appDomainEnabled,
        public readonly string $appRoot,
        public readonly int $nginxBasicAuthEnabled,
        public readonly array $nginxBasicAuthUsers,
        public readonly array $trustedIps,
        public readonly int $nodeModulesSymlink,
        public readonly int $vendorSymlink,
        public readonly int $staticFileCache,
        public readonly int $autoArtisanMigrations,
        public readonly string $defaultComposerVersion,
        public readonly array $autoDeployTagPatterns,
        public readonly array $autoDeployBranchPatterns,
    ) {}

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'environment_name' => $this->environmentName,
            'state' => $this->state,
            'storage_directory' => $this->storageDirectory,
            'ssh_enabled' => $this->sshEnabled,
            'maintenance_mode_enabled_at' => $this->maintenanceModeEnabledAt->toDateTimeString(),
            'ssh_port' => $this->sshPort,
            'app_domain' => $this->appDomain,
            'current_deployment_id' => $this->currentDeploymentId,
            'container_root_directory' => $this->containerRootDirectory,
            'app_type' => $this->appType,
            'auto_deploy_enabled' => $this->autoDeployEnabled,
            'repo_owner' => $this->repoOwner,
            'repo_name' => $this->repoName,
            'branch_name' => $this->branchName,
            'provider_name' => $this->providerName,
            'maintenance_mode_enabled' => $this->maintenanceModeEnabled,
            'auto_install_composer' => $this->autoInstallComposer,
            'webroot' => $this->webroot,
            'app_domain_enabled' => $this->appDomainEnabled,
            'app_root' => $this->appRoot,
            'nginx_basic_auth_enabled' => $this->nginxBasicAuthEnabled,
            'nginx_basic_auth_users' => $this->nginxBasicAuthUsers,
            'trusted_ips' => $this->trustedIps,
            'node_modules_symlink' => $this->nodeModulesSymlink,
            'vendor_symlink' => $this->vendorSymlink,
            'static_file_cache' => $this->staticFileCache,
            'auto_artisan_migrations' => $this->autoArtisanMigrations,
            'default_composer_version' => $this->defaultComposerVersion,
            'auto_deploy_tag_patterns' => $this->autoDeployTagPatterns,
            'auto_deploy_branch_patterns' => $this->autoDeployBranchPatterns,
        ];
    }
}
