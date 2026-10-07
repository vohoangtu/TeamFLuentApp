<?php

namespace App\DTOs;

readonly class TeamData
{
    public function __construct(
        public string $name,
        public string $code,
        public ?string $description,
        public ?string $color = null,
        public ?int $leadId = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) $data['name'],
            code: (string) $data['code'],
            description: isset($data['description']) ? (string) $data['description'] : null,
            color: isset($data['color']) ? (string) $data['color'] : null,
            leadId: isset($data['lead_id']) && $data['lead_id'] !== '' ? (int) $data['lead_id'] : null,
        );
    }
}
