<?php

namespace App\Security\Voter;

use App\Entity\UserType\Agent;

/**
 * Interface PropertyVoterInterface
 * @package App\Security\Voter
 */
interface PropertyVoterInterface {
    public function getAgent() : ?Agent;
}