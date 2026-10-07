<?php

namespace App\DTOs;

readonly class AssignProjectData
{
    public function __construct(
        public int $projectId,
        public string $roleInProject,
        public int $allocationPercent,
        public ?string $assignedAt = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            projectId: (int) $data['project_id'],
            roleInProject: (string) ($data['role_in_project'] ?? 'Contributor'),
            allocationPercent: (int) ($data['allocation_percent'] ?? 50),
            assignedAt: isset($data['assigned_at']) ? (string) $data['assigned_at'] : null,
        );
    }
}
