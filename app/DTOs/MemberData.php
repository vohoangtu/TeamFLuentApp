<?php

namespace App\DTOs;

use App\Enums\MemberStatus;

readonly class MemberData
{
    /**
     * @param  list<int>  $projectIds
     */
    public function __construct(
        public string $name,
        public string $email,
        public ?string $phone,
        public ?string $avatarUrl,
        public int $teamId,
        public int $roleId,
        public bool $isTeamLead,
        public MemberStatus $status,
        public ?string $bio = null,
        public ?string $joinedAt = null,
        public array $projectIds = [],
        public ?string $projectRole = null,
        public ?int $allocationPercent = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) $data['name'],
            email: (string) $data['email'],
            phone: isset($data['phone']) ? (string) $data['phone'] : null,
            avatarUrl: isset($data['avatar_url']) ? (string) $data['avatar_url'] : null,
            teamId: (int) $data['team_id'],
            roleId: (int) $data['role_id'],
            isTeamLead: (bool) ($data['is_team_lead'] ?? false),
            status: $data['status'] instanceof MemberStatus
                ? $data['status']
                : MemberStatus::from((string) $data['status']),
            bio: isset($data['bio']) ? (string) $data['bio'] : null,
            joinedAt: isset($data['joined_at']) ? (string) $data['joined_at'] : null,
            projectIds: array_map('intval', $data['project_ids'] ?? []),
            projectRole: isset($data['project_role']) ? (string) $data['project_role'] : null,
            allocationPercent: isset($data['allocation_percent']) ? (int) $data['allocation_percent'] : null,
        );
    }
}
