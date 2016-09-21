<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 21/09/16
 * Time: 16:58
 */

namespace AppBundle\Security;


use AppBundle\Entity\Folder;
use AppBundle\Entity\Photo;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;

    }

    protected function supports($attribute, $subject)
    {
        return ($subject instanceof Folder || $subject instanceof Photo ) && in_array($attribute, array(
            self::DELETE, self::EDIT
        ));
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($this->decisionManager->decide($token, ['ROLE_SUPERADMIN'])){
            return true;
        }

        // A user can only edit a photo or folder that the user itself uploaded
        if ($attribute === self::EDIT && $user === $subject->getUser()) {
            return true;
        }

        // A user can only delete a photo or folder that the user itself uploaded
        if ($attribute === self::DELETE && $user === $subject->getUser()) {
            return true;
        }

        return false;
    }
}








//        switch ($attribute) {
//            case self::EDIT:
//                return $this->canEdit($attribute, $subject, $user);
//            case self::DELETE:
//                return $this->canDelete($attribute, $subject, $user);
//        }


//    public function canEdit($attrbiute, $subject, $user)
//    {
//        dump($attribute);die;
////        if ($attribute === self::EDIT && $user->getId() === $subject->getUser()->getId()) {
////            return true;
////        }
//
////        return false;
//    }
//
//    public function canDelete($subject, $user)
//    {
//        return $user === $subject->getUser;
//    }
//
//}