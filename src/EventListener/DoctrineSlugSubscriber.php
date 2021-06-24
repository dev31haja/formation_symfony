<?php
namespace App\EventListener;


use App\Entity\Product;
use App\Service\Slugify;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class DoctrineSlugSubscriber implements EventSubscriber{
    private $slugify_service;
    private $logger;

    public function __construct(Slugify $slugify, LoggerInterface $logger)
    {
        $this->slugify_service = $slugify;
        $this->logger = $logger;
    }
    
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        // empty
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        // empty
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        
        if ($entity instanceof Product) {
            
            if(array_key_exists('name', $args->getEntityChangeSet())){
                $this->logger->debug('preUpdate Product => name changed');
                // update slug based on new name
                $entity->setSlug($this->slugify_service->slugify($entity->getName()));
            }
            
        }
        
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        // new entity
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Product) {
            $entity->setSlug($this->slugify_service->slugify($entity->getName()));
        }
    }
}