<?php

namespace Library;

class CpuMemUse
{

    public function __construct()
    {
    }

    public function getProCpuUsage($program)
    {
        if (!$program) return -1;

        $c_pid = exec("ps aux | grep " . $program . " | grep -v grep | grep -v su | awk {'print $3'}");
        return $c_pid;
    }

    public function getProMemUsage($program)
    {
        if (!$program) return -1;

        $c_pid = exec("ps aux | grep " . $program . " | grep -v grep | grep -v su | awk {'print $4'}");
        return $c_pid;
    }
}

//$obj = new CpuMemUse();
//$pro = 'php';
//echo "CPU use of Program: " . $obj->getProCpuUsage($pro) . "%";
//echo "Mem Use of Program: " . $obj->getProMemUsage($pro) . "%";