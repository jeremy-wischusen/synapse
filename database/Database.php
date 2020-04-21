<?php

/**
 * Manages connections to database.
 *
 * @author Jeremy Wischusen
 */

class Database {

    /**
     *
     * @var array
     */
    private static $instances = array();
    private static $connections = array(
        'default'=>array(
            'username'=>'someuser',
            'password'=>'somepassword',
            'dsn'=>'mysql:dbname=somedb;host=localhost'
        )
    );

    /**
     *
     * @return PDO;
     */
    public static function getInstance($connection = 'default', $config = null) {
         global $CONFIG;
        $connections = empty($CONFIG['dbconnections'])?self::$connections:$CONFIG['dbconnections'];
        if (!empty($connections) && self::$instances[$connection] === null) {
           $con = $connections[$connection];
            self::$instances[$connection] = new PDO($con['dsn'], $con['username'], $con['password'], $config);
        }
        return self::$instances[$connection];
    }

}

?>
