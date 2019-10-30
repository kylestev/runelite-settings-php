<?php

namespace Kylestev\RuneLite;

/**
 * @Annotation
 * @TARGET("CLASS")
 */
class SettingsGroup
{
    /** @var string */
    public $group;

    public function __construct(array $args)
    {
        $this->group = $args['value'];
    }
}

interface HasValue
{
    function getValue($value);
}

abstract class BaseProperty implements HasValue
{
    public $default;

    public $key;

    abstract function getValue($value);
}

/**
 * @Annotation
 * @TARGET("PROPERTY")
 */
class IntProperty extends BaseProperty
{
    function getValue($value)
    {
        return (int) $value;
    }
}

/**
 * @Annotation
 * @TARGET("PROPERTY")
 */
class StringProperty extends BaseProperty
{
    function getValue($value)
    {
        return (string) $value;
    }
}
