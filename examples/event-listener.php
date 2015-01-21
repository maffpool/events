#!/usr/bin/php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$serializer = new \Evaneos\Events\EventSerializer();
$serializer->bindSerializer('test.simple', new \Evaneos\Events\Example\TestEventSerializer());

$eventDispatcher = new \Evaneos\Events\StandardDispatcher();
$eventDispatcher->addListener('test.*', new \Evaneos\Events\Example\TestEventSubscriber());

$handler = new \Burrow\RabbitMQ\AmqpAsyncHandler('127.0.0.1', 5672, 'guest', 'guest', 'app1');
$handler->registerConsumer(new \Evaneos\Events\QueueConsumers\MessageQueue\MessageQueueConsumer($eventDispatcher, $serializer));

$worker = new \Burrow\Worker($handler);
$worker->run();
