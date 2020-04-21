<?php

/**
 * Manages connections to database.
 *
 * @author jeremy
 */
class FTP {

    /**
     *
     * @var array
     */
    private static $instances = array();
    private static $connections = array(
        'default'=>array(
            'host' => 'ftp.someserver.com',
            'dir' => 'IN',
            'username' => 'someuser',
            'password' => 'somepass',
        )
    );

    /**
     *
     * @return AbstractDatabaseInterface;
     */
    public static function getInstance($connection = 'default') {
        if (self::$instances[$connection] === null) {
            $config = self::$connections[$connection];
            $ftp = ftp_connect($config['host']);
            if ($ftp) {
                if (!ftp_login($ftp, $config['username'], $config['password'])) {
                    ftp_close($ftp);
                }
            }
            self::$instances[$connection] = $ftp;
        }
        return self::$instances[$connection];
    }
}

?>
