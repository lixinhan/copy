<?php
namespace Lixinhan\CopyTest;
use Lixinhan\Copy\ObjectCopy;
use Lixinhan\CopyTest\data\ObjectA;
use \PHPUnit\Framework\TestCase;
class ObjectUtilTest extends TestCase
{
    public function testCopy(){
        $demoA=new ObjectA();
        $array=[
          'public'=>3,
          'int'=>"cccc",
          'objectB'=>['b'=>12312312],
          'objectC'=>['list'=>['asf','asdf','adsfasd']]
        ];
        ObjectCopy::copy($array,$demoA);
        var_dump($demoA);
    }

}
