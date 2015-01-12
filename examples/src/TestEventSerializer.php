<?php
namespace Evaneos\Events\Example;

use Evaneos\Events\Serializer;

class TestEventSerializer implements Serializer
{
    /**
     * {@inheritDoc}
     *
     * @param TestEvent $object
     */
    public function serialize($object)
    {
        $serializable = new \stdClass();
        $serializable->value = $object->getValue();
        $serializable->category = $object->getCategory();

        return json_encode($serializable);
    }

    /**
     * {@inheritDoc}
     */
    public function deserialize($serializedObject)
    {
        $deserialized = json_decode($serializedObject);

        return new TestEvent($deserialized->value);
    }
}
