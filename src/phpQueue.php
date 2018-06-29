<?php
/**
 * Desc: php数组实现队列 FIFO
 * Created by PhpStorm.
 * User: jasong
 * Date: 2017/12/14 17:19
 * 1. 伟入，首出
 * 2. 首入，伟出
 */

namespace Library;

class PhpQueue
{

    private $jobQueue;

    //队伟-入
    public function footPut($job){
        array_push($this->jobQueue, $job);
    }

    //队首-出
    public function headOut(){
        $job = array_shift($this->jobQueue);

        return $job;
    }


    //队首-入
    public function headPut($job){
        array_unshift($this->jobQueue, $job);
    }


    //队伟-出
    public function footOut(){
        $job = array_pop($this->jobQueue);

        return $job;
    }

    //队列大小
    public function len(){
        return count($this->jobQueue);
    }

    //第一个元素
    public function firstJob(){
        return reset($this->jobQueue);
    }

    //最后一个元素
    public function lastJob(){
        return end($this->jobQueue);
    }

    //清空队列
    public function clear(){
        unset($this->jobQueue);
    }
}