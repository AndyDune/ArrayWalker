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


class ItemContainer
{
    protected $arrayWalker;

    protected $value;
    protected $key;
    protected $stopped = false;
    protected $deleted = false;

    public function __construct(ArrayWalker $arrayWalker)
    {
        $this->arrayWalker = $arrayWalker;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStopped()
    {
        return $this->stopped;
    }

    /**
     * @param bool $stopped
     */
    public function stop()
    {
        $this->stopped = true;
        return $this;
    }

    /**
     * @param string|callable $function
     * @return array
     * @throws \Exception
     */
    public function apply($function)
    {
        $arrayWalker = clone($this->arrayWalker);
        $arrayWalker->setArray($this->getValue());
        return $arrayWalker->apply($function);
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function delete()
    {
        $this->deleted = true;
        return $this;
    }


}