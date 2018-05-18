<?php
/**
 *
 * PHP version >= 5.6
 *
 * @package andydune/array-walker
 * @link  https://github.com/AndyDune/ArrayWalker for the canonical source repository
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Andrey Ryzhov  <info@rznw.ru>
 * @copyright 2018 Andrey Ryzhov
 */


namespace AndyDuneTest\ArrayWalker;
use AndyDune\ArrayWalker\ArrayWalker;
use AndyDune\ArrayWalker\ItemContainer;
use PHPUnit\Framework\TestCase;


class ArrayWalkerTest extends TestCase
{

    public function testArrayWalker()
    {
        $array = [
            'one' => 1,
            'two' => 2,
            'three' => 3,
        ];

        $arrayWalker = new ArrayWalker($array);
        $arrayWalker->addFunction(function (ItemContainer $item) {
            $item->setValue($item->getValue() + 10);
        });
        $result = $arrayWalker->apply();
        $this->assertCount(3, $result);
        $this->assertEquals(11, $result['one']);
        $this->assertEquals(12, $result['two']);
        $this->assertEquals(13, $result['three']);

        $arrayWalker = new ArrayWalker($array);
        $arrayWalker->addFunction(function (ItemContainer $item) {
            $item->setKey(strtoupper($item->getKey()));
        });
        $result = $arrayWalker->apply();
        $this->assertCount(3, $result);
        $this->assertEquals(1, $result['ONE']);
        $this->assertEquals(2, $result['TWO']);
        $this->assertEquals(3, $result['THREE']);


        $arrayWalker = new ArrayWalker();
        $arrayWalker->addFunction(function (ItemContainer $item) {
            $item->setValue($item->getValue() + 10);
            if ($item->getKey() == 'two') {
                $item->stop();
            }
        });
        $arrayWalker->setArray($array);
        $result = $arrayWalker->apply();
        $this->assertCount(2, $result);
        $this->assertEquals(11, $result['one']);
        $this->assertEquals(12, $result['two']);


        $arrayWalker = new ArrayWalker($array);
        $arrayWalker->addFunction(function (ItemContainer $item) {
            $item->setValue($item->getValue() + 10);
            if ($item->getKey() == 'one') {
                $item->delete();
            }
        });
        $result = $arrayWalker->apply();
        $this->assertCount(2, $result);
        $this->assertEquals(12, $result['two']);
        $this->assertEquals(13, $result['three']);

    }
}