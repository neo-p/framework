<?php 

namespace NeoP\Component;

use NeoP\Component\ComponentInterface;

class ComponentRegister
{
    private static $components = [];

    public static function addComponent( ComponentInterface $component ): void
    {
        array_push(self::$components, $component);
    }
    
    public static function getComponents(): array
    {
        return self::$components;
    }
}