<?php

namespace App\DTOs;

readonly class PermissionGroupData
{
    /**
     * @param  list<string>  $permissions
     */
    public function __construct(
        public string $name,
        public string $slug,
        public string $badgeColor = 'indigo',
        public string $icon = '⚡',
        public ?string $description = null,
        public array $permissions = [],
        public bool $isSystem = false,
    ) {}
}
