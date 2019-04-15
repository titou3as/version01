<?php

namespace App\Security\Voter;

use App\Entity\Contributor;
use App\Entity\Decision;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class DecisionVoter extends Voter
{
    const CREATE = 'create';
    const VIEW   = 'view';
    const UPDATE = 'update';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {

        return in_array($attribute, [self::CREATE, self::VIEW,self::UPDATE,self::DELETE])
            && $subject instanceof Decision;
    }

    /**
     * @param string $attribute
     * @param Decision $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $contributor = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$contributor instanceof Contributor) {
            return false;
        }

        /**
         * @var Decision $decision
         */
        $decision = $subject;
        switch ($attribute) {
            /*
            case self::CREATE:
                 // logic to determine if the user can CREATE
                // return true or false
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                 break;
            */
            case self::UPDATE :
                return $contributor === $decision->getContributor();
                break;
            /*
            case self::DELETE :
                break;
            */
        }

        return false;
    }
}
