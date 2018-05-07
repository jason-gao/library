<?php

/**
 * author:jasong
 */

namespace Library;

/**
 * 单例抽象类
 * Abstract class for other class extends
 * use: class::singleton()
 */
abstract class Abstraction
{

    /**
     * @param array $params
     * @return null|static
     * @node_name Singleton design pattern
     * @link
     * @desc
     */
    public static function singleton($params = [])
    {
        static $instance = null;

        if (null === $instance) {
            $instance = $params ? new static($params) : new static();
        }

        return $instance;
    }
}
