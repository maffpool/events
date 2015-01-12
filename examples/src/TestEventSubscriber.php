<?php
namespace Evaneos\Events\Example;

use Evaneos\Events\EventSubscriber;
use Evaneos\Events\Event;

class TestEventSubscriber implements EventSubscriber
{
    public function handle(Event $event)
    {
        echo 'Event #' . ($event->getValue()+1) . "\n" ;
    }
    
    public function supports(Event $event)
    {
        return $event instanceof TestEvent;
    }
}
