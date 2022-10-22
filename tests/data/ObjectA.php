<?php

declare(strict_types=1);
/**
 *
 * @author  lixinhan<github@lixinhan.com>
 *
 */
namespace Lixinhan\CopyTest\data;

class ObjectA
{
    public $public;

    public int $int;

    public array $array;

    public bool $bool;

    public float $float;

    public $default = 1;

    public ObjectB $objectB;

    public ObjectC $objectC;

    private $a;
}
