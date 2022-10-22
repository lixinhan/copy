<?php

declare(strict_types=1);
/**
 *
 * @author  lixinhan<github@lixinhan.com>
 *
 */
namespace Lixinhan\Copy;

class ObjectCopy
{
    public static function copy($from, $to)
    {
        // 统一格式处理格式
        if (is_scalar($from) || is_scalar($to)) {
            return $to;
        }
        if (is_array($from)) {
            $fromArray = $from;
        } else {
            $fromArray = json_decode(json_encode($from), true);
        }

        $toReflection = new \ReflectionClass($to);
        $toProperties = $toReflection->getProperties();
        foreach ($toProperties as $property) {
            if ($property->isProtected() || $property->isPrivate()) {
                // 如果不是公共访问的属性，那么跳过
                continue;
            }
            $itemValue = $fromArray[$property->name] ?? null;
            $propertyType = $property->getType();

            if (isset($propertyType)) {
                // 如果设置了
                if (! isset($fromArray[$property->name])) {
                    if ($property->getType()->allowsNull()) {
                        // 但是设置类型并且属性值允许孔
                        $to->{$property->name} = null;
                    }
                    continue;
                }
            }
            $propertyTypeName = ($propertyType == null ? null : $propertyType->getName());
            switch ($propertyTypeName) {
                case 'bool':
                    $to->{$property->name} = intval($itemValue);
                    break;
                case 'int':
                    $to->{$property->name} = boolval($itemValue);
                    break;
                case 'float':
                    $to->{$property->name} = floatval($itemValue);
                    break;
                case 'string':
                    $to->{$property->name} = strval($itemValue);
                    break;
                case 'array':
                    $to->{$property->name} = $itemValue;
                    // no break
                case null:
                    $to->{$property->name} = $itemValue;
                    break;
                default:
                    $className = $property->getType()->getName();
                    $class = new $className();
                    self::copy($itemValue, $class);
                    $to->{$property->name} = $class;
            }
        }
        return $to;
    }
}
