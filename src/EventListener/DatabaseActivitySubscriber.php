<?php

namespace App\EventListener;

use App\Log\LogAware;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DatabaseActivitySubscriber implements EventSubscriberInterface
{
    private $tokenStorage;
    private $requestStack;
    private $auditLogger;

    public function __construct(TokenStorageInterface $tokenStorage, RequestStack $requestStack, LoggerInterface $auditLogger)
    {
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
        $this->auditLogger = $auditLogger;
    }
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::preRemove,
            Events::preUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->logActivity('remove', $args);
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs|PreUpdateEventArgs $args): void
    {
        try {
            $entity = $args->getObject();
            // $entityManager = $args->getObjectManager();

            // if this subscriber only applies to certain entity types,
            // add some code to check the entity type as early as possible
            if (!$entity instanceof LogAware) {
                // dd($entity);
                return;
            }

            $user = $this->tokenStorage->getToken() ? $this->tokenStorage->getToken()->getUser() : null;
            $date = date('d/m/Y H:i:s');

            $logMessage = $date . ' User ' . $user . ' '
                . $action . ' '
                . get_class($entity) . ' information'
                . ' of id: ' . $entity->getId();

            $context = [
                'user' => $user,
                'action' => $action,
                'entity' => $entity,
                'id' => $entity->getId(),
            ];
            // dd(date('Y-m-d H:i:s'));
            if ($action == 'update') {
                $logMessage .= ' [';
                $changedFields = $args->getEntityChangeSet();
                $context['fields'] = $changedFields;
                // dd(json_encode($changedFields));
                foreach ($changedFields as $field => $changes) {
                    if (is_array($changes[0])) {
                        $changes[0] = json_encode($changes[0]);
                    }
                    if (is_array($changes[1])) {
                        $changes[1] = json_encode($changes[1]);
                    }
                    $logMessage .= ' ' . $field . '(' . $changes[0] . ' > ' . $changes[1] . ')';
                }
                $logMessage .= ' ]';
            }

            $logMessage .= ' from IP: ' . $this->requestStack->getMainRequest()?->getClientIp()
                . "\n";

            $context['ip'] = $this->requestStack->getMainRequest()?->getClientIp();

            // $this->auditLogger->info($logMessage, $context);

            $logsFile = 'audit.log';
            file_put_contents($logsFile, $logMessage, FILE_APPEND);
            // dd($logMessage, $this->requestStack->getMainRequest()->getClientIp());
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
