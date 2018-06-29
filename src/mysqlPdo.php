<?php
/**
 * Desc: mysql pdo
 * Created by PhpStorm.
 * User: jason-gao
 * Date: 2018/5/24 14:49
 * https://blog.csdn.net/fdipzone/article/details/53117541
 */

namespace Library;

use PDO;
use PDOException;
use Ypf\Exception;

class mysqlPdo extends PDO
{

    // 保存数据库连接
    private static $_instance = null;

    // 连接数据库
    public static function get_conn($config)
    {
        if (isset(self::$_instance) && !empty(self::$_instance)) {
            return self::$_instance;
        }

        $dbhost   = $config['host'];
        $dbname   = $config['dbname'];
        $dbuser   = $config['user'];
        $dbpasswd = $config['password'];
        $pconnect = $config['pconnect'];
        $charset  = $config['charset'];

        $dsn = "mysql:host=$dbhost;dbname=$dbname;";
        try {
            $h_param = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            );
            if ($charset != '') {
                $h_param[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . $charset; //設置默認編碼
            }
            if ($pconnect) {
                $h_param[PDO::ATTR_PERSISTENT] = true;
            }
            $conn = new PDO($dsn, $dbuser, $dbpasswd, $h_param);

        } catch (PDOException $e) {
            throw new Exception('Unable to connect to db server. Error:' . $e->getMessage(), 31);
        }

        self::$_instance = $conn;
        return $conn;
    }

    // 执行查询
    public static function query($dbconn, $sqlstr, $condparam)
    {
        $sth = $dbconn->prepare($sqlstr);
        try {
            $sth->execute($condparam);
        } catch (PDOException $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // 重置连接
    public static function reset_connect()
    {
        self::$_instance = null;
    }

}
