#!/usr/bin/php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$queueService = new \Burrow\RabbitMQ\AmqpSimpleService('127.0.0.1', 5672, 'guest', 'guest', 'app1');

$serializer = new \Evaneos\Events\EventSerializer();
$serializer->bindSerializer('test.simple', new \Evaneos\Events\Example\TestEventSerializer());

$eventDispatcher = new \Evaneos\Events\StandardDispatcher();
$eventDispatcher->addListener('test.*', new \Evaneos\Events\Example\TestEventSubscriber());

$worker = new \Evaneos\Events\Workers\MessageQueue\MessageQueueWorker($queueService, $eventDispatcher, $serializer);
$worker->daemonize();
