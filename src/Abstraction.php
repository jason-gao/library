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
abstract class Abstraction {
    /**
     * Singleton design pattern
     * 
     * @return mixed
     */
    public static function singleton() {
        static $instance = null;
        
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }
}
