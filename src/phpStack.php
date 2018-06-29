<?php
/**
 * Desc: php数组实现栈 FILO
 * Created by PhpStorm.
 * User: jasong
 * Date: 2017/12/14 17:19
 * 先入后出，后入先出
 */

namespace Library;

class PhpStack
{

    private $table;

    //入
    public function topPut($job){
        array_push($this->table, $job);
    }

    //出
    public function topOut(){
        $job = array_pop($this->table);

        return $job;
    }

    //栈大小
    public function len(){
        return count($this->table);
    }

    //第一个元素
    public function firstJob(){
        return reset($this->table);
    }

    //最后一个元素
    public function lastJob(){
        return end($this->table);
    }

    //清空栈
    public function clear(){
        unset($this->table);
    }
}