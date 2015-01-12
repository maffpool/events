<?php
namespace Evaneos\Events\Workers\MessageQueue;

use Burrow\AbstractWorker;
use Burrow\Worker;
use Burrow\QueueService;
use Evaneos\Events\EventDispatcher;
use Evaneos\Events\Serializer;

class EchoWorker extends AbstractWorker implements Worker
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
     * @param QueueService $queueService
     * @param EventDispatcher $eventDispatcher
     * @param Serializer $serializer
     */
    public function __construct(QueueService $queueService, EventDispatcher $eventDispatcher, Serializer $serializer)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->serialize = $serializer;
        parent::__construct($queueService);
    }
    
    /**
     * Event Dispatcher getter
     * 
     * @return \Evaneos\Events\EventDispatcher
     */
    function getEventDispatcher() {
        return $this->eventDispatcher;
    }
    
    /**
     * Serializer getter
     * 
     * @return \Evaneos\Events\Serializer
     */
    function getSerializer() {
        return $this->serializer;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Burrow\AbstractWorker::init()
     */
    protected function init()
    {
        $self = $this;
        
        $this->queueService->registerConsumer(function($messageBody) use ($self) {
            $event = $self->serializer->deserialize($messageBody);
            $self->getEventDispatcher()->dispatch($event);
        });
    }
}
