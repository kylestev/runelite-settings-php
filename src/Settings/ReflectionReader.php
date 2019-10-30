<?php

namespace Kylestev\RuneLite\Settings;

use ReflectionClass;
use Kylestev\RuneLite\IntProperty;
use Kylestev\RuneLite\StringProperty;
use Doctrine\Common\Annotations\AnnotationReader;

class ReflectionReader extends ModuleSettings
{
    /** @var ReflectionClass */
    private $reflectionClass;

    /** @var AnnotationReader */
    private $reader;

    /** @var array|null */
    private $properties;

    public function __construct(
        ReflectionClass $reflectionClass,
        AnnotationReader $reader
    )
    {
        $this->reflectionClass = $reflectionClass;
        $this->reader = $reader;
        $this->properties = null;
    }

    private function loadProperties()
    {
        if ($this->properties !== null) {
            return;
        }

        $properties = $this->reflectionClass->getProperties();
        foreach ($properties as $property) {
            $key = $property->getName();
            $annotations = $this->reader->getPropertyAnnotations($property);
            foreach ($annotations as $annotation) {
                $type = get_class($annotation);
                if (in_array($type, [StringProperty::class, IntProperty::class])) {
                    if (isset($annotation->key) && $annotation->key !== null) {
                        $properties[$annotation->key] = $annotation;
                    } else {
                        $properties[$key] = $annotation;
                    }
                    break;
                }
            }
        }

        $this->properties = $properties;
    }

    public function parseSetting(string $key, string $value)
    {
        $this->loadProperties();

        if (array_key_exists($key, $this->properties)) {
            $prop = $this->properties[$key];

            return $prop->getValue($value);
        }

        return null;
    }
}
