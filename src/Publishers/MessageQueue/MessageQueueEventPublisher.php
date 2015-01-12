<?php
namespace Evaneos\Events\Publishers\MessageQueue;

use Burrow\QueueService;
use Evaneos\Events\EventPublisher;
use Evaneos\Events\Event;
use Evaneos\Events\Serializer;

class MessageQueueEventPublisher implements EventPublisher
{

    /**
     * @var QueueService
     */
    private $queueService;
    
    /**
     * @var Serializer
     */
    private $serializer;
    
    /**
     * Constructor
     * 
     * @param QueueService $queueService
     */
    public function __construct(QueueService $queueService, Serializer $serializer)
    {
        $this->queueService = $queueService;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritDoc}
     */
    public function publish(Event $event)
    {
        $serializedEvent = $this->serializer->serialize($event);
        $this->queueService->publish($serializedEvent);
    }
}
