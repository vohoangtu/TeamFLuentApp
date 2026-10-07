<?php

namespace App\DTOs;

readonly class RoleData
{
    /**
     * @param  list<string>  $permissions
     */
    public function __construct(
        public string $name,
        public ?string $slug,
        public string $badgeColor,
        public ?string $description,
        public array $permissions,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) $data['name'],
            slug: isset($data['slug']) && $data['slug'] !== '' ? (string) $data['slug'] : null,
            badgeColor: (string) ($data['badge_color'] ?? 'purple'),
            description: isset($data['description']) ? (string) $data['description'] : null,
            permissions: array_values((array) ($data['permissions'] ?? [])),
        );
    }
}
