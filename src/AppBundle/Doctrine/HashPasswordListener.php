<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 20/09/16
 * Time: 11:54
 */

namespace AppBundle\Doctrine;


use AppBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class HashPasswordListener implements EventSubscriber
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    public function encodePassword(User $entity)
    {
        if (!$entity->getPlainPassword())
        {
            return;
        }

        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPlainPassword()
        );
        $entity->setPassword($encoded);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User){
            return;
        }

        $this->encodePassword($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof User){
            return;
        }

        $this->encodePassword($entity);

        $em = $args->getObjectManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }
}