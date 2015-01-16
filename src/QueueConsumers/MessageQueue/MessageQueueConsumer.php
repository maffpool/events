<?php
namespace Evaneos\Events\QueueConsumers\MessageQueue;

use Evaneos\Events\EventDispatcher;
use Evaneos\Events\Serializer;
use Evaneos;
use Burrow\QueueConsumer;

class MessageQueueConsumer implements QueueConsumer
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    
    /**
     * 
     * @var Serializer
     */
    private $serializer;
    
    /**
     * Constructor
     * 
     * @param EventDispatcher $eventDispatcher
     * @param Serializer $serializer
     */
    public function __construct(EventDispatcher $eventDispatcher, Serializer $serializer)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Burrow\QueueConsumer::consume()
     */
    public function consume($message)
    {
        $event = $this->serializer->deserialize($message);
        if ($event !== null && $event instanceof Evaneos\Events\Event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
