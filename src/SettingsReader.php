<?php

namespace Kylestev\RuneLite;

include_once 'Annotations.php';

use Exception;
use ReflectionClass;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Kylestev\RuneLite\Settings\ModuleSettings;
use Kylestev\RuneLite\Settings\ReflectionReader;

class SettingsReader
{
    private $reader;

    /** @var array<array<stdClass>> */
    private $groups;

    public function __construct(AnnotationReader $reader)
    {
        $this->reader = $reader;
        $this->groups = [];

        AnnotationRegistry::registerLoader('class_exists');
    }

    public function readSetting(string $group, string $key, string $value)
    {
        if (!array_key_exists($group, $this->groups)) {
            return null;
        }

        $group = $this->groups[$group];
        return $group->parseSetting($key, $value);
    }

    public function registerGroupReader(string $classType)
    {
        $reflectionClass = new ReflectionClass($classType);
        $group = $this->getGroupAnnotation($reflectionClass);

        if ($group === null) {
            throw new Exception('Unannotated class: '.$classType);
        }

        $instance = $reflectionClass->newInstance();
        if ($reflectionClass->isSubclassOf(ModuleSettings::class)) {
            $this->groups[$group] = $instance;
        } else {
            $this->groups[$group] = new ReflectionReader($reflectionClass, $this->reader);
        }
    }

    private function getGroupAnnotation(ReflectionClass $reflectionClass)
    {
        $groupAnnotation = $this->reader->getClassAnnotation(
            $reflectionClass,
            SettingsGroup::class
        );

        if ($groupAnnotation !== null) {
            return $groupAnnotation->group;
        }

        return null;
    }
}
