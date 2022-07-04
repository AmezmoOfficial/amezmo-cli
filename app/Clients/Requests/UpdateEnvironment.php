<?php

declare(strict_types=1);

namespace App\Clients\Requests;

final class UpdateEnvironment
{
    public function __construct(
        public readonly null|array $autoDeployTagPatterns,
        public readonly null|array $autoDeployBranchPatterns,
        public readonly null|string $newRelicLicenseKey,
        public readonly null|bool $sshEnabled,
        public readonly null|array $trustedIps,
    ) {}

    public function toArray(): array
    {
        $array = [];

        if (null !== $this->autoDeployTagPatterns) {
            $array['auto_deploy_tag_patterns'] = $this->autoDeployTagPatterns;
        }

        if (null !== $this->autoDeployBranchPatterns) {
            $array['auto_deploy_branch_patterns'] = $this->autoDeployBranchPatterns;
        }

        if (null !== $this->newRelicLicenseKey) {
            $array['new_relic_license_key'] = $this->newRelicLicenseKey;
        }

        if (null !== $this->sshEnabled) {
            $array['ssh_enabled'] = $this->sshEnabled;
        }

        if (null !== $this->trustedIps) {
            $array['trusted_ips'] = $this->trustedIps;
        }

        return $array;
    }
}
