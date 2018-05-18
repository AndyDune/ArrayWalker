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


namespace AndyDune\ArrayWalker;


class ArrayWalker
{
    protected $array = [];
    protected $functions = [];

    public function __construct($array = [])
    {
        $this->array = $array;
    }

    /**
     * @param array $array
     */
    public function setArray(array $array)
    {
        $this->array = $array;
        return $this;
    }


    public function addFunction($function, $name = 'default')
    {
        $this->functions[$name] = $function;
        return $this;
    }

    public function apply($functionName = 'default')
    {
        if (is_callable($functionName)) {
            $function = $functionName;
        } else if (!array_key_exists($functionName, $this->functions)) {
            throw new \Exception(sprintf('The is no function with name $s', $functionName));
        } else {
            $function = $this->functions[$functionName];
        }

        $arrayResult = [];

        foreach ($this->array as $key => $value) {
            $container = new ItemContainer($this);
            $container->setKey($key)
                ->setValue($value);
            call_user_func($function, $container);
            if (!$container->isDeleted()) {
                $arrayResult[$container->getKey()] = $container->getValue();
            }

            if ($container->isStopped()) {
                break;
            }
        }
        return $arrayResult;
    }
}