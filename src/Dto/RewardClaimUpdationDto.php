<?php

namespace App\Dto;

use ApiPlatform\Metadata as API;
use App\Entity\Project\RewardClaimStatus;
use Symfony\Component\Validator\Constraints as Assert;

class RewardClaimUpdationDto
{
    /**
     * The point at which the claim over the reward is.\
     * May only be updated by admins or the User who owns the Project of the ProjectReward.
     */
    #[Assert\NotBlank()]
    #[API\ApiProperty(security: 'is_granted("CLAIM_EDIT", object)')]
    public RewardClaimStatus $status;
}
