<?php

namespace App\DTOs;

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;

readonly class ProjectData
{
    public function __construct(
        public string $name,
        public string $code,
        public ?string $description,
        public ProjectStatus $status,
        public ProjectPriority $priority,
        public int $progress,
        public ?string $color = null,
        public ?string $startDate = null,
        public ?string $dueDate = null,
        public ?float $budget = null,
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
            status: $data['status'] instanceof ProjectStatus
                ? $data['status']
                : ProjectStatus::from((string) $data['status']),
            priority: $data['priority'] instanceof ProjectPriority
                ? $data['priority']
                : ProjectPriority::from((string) $data['priority']),
            progress: (int) ($data['progress'] ?? 0),
            color: isset($data['color']) ? (string) $data['color'] : null,
            startDate: isset($data['start_date']) ? (string) $data['start_date'] : null,
            dueDate: isset($data['due_date']) ? (string) $data['due_date'] : null,
            budget: isset($data['budget']) && $data['budget'] !== '' ? (float) $data['budget'] : null,
        );
    }
}
