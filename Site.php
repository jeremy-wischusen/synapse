<?php
/*
 * Created by Jeremy Wischusen - Jan 29, 2010.
 */

//debugging
/*
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/
define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DOMAIN', str_replace('www.', '', $_SERVER['HTTP_HOST']));
define('INSTALL_DIR', SITE_ROOT . '/synapse');
define('APP_DIR', SITE_ROOT . '/app');
define('CURRENT_DIR', getcwd());
/**
 * Include the most commonly used framework files so that we do not have to search for them.
 */
require_once INSTALL_DIR . '/View.php';
require_once INSTALL_DIR . '/Model.php';
require_once INSTALL_DIR . '/Controller.php';
require_once INSTALL_DIR . '/Command.php';
require_once INSTALL_DIR . '/database/Database.php';
require_once INSTALL_DIR . '/helpers/Post.php';
require_once INSTALL_DIR . '/helpers/Get.php';
require_once INSTALL_DIR . '/helpers/Session.php';

/**
 * Config. Load configuration files.
 */
$CONFIG = array();
//default config
$defaultConfig = APP_DIR . '/config/default.php';
if (file_exists($defaultConfig)) {
    require_once $defaultConfig;
}
$domainConfig = APP_DIR . '/config/' . DOMAIN . '.php';
//if a domain specific config exists load it.
if (file_exists($domainConfig)) {
    require_once $domainConfig;
}
/**
 *
 *
 * @author Jeremy Wischusen
 */
class Site {

    /**
     * Contains the file paths to be searched for classes. Paths will be searched in the order that they are specified in the array.
     * @var array
     */
    public static $classPaths = array(APP_DIR, INSTALL_DIR);

    public static function findFile($fileName, $classPaths) {
//        echo"<h1>Looking for {$fileName}</h1>";
        foreach ($classPaths as $dir) {
//            echo"<h3>Looking in {$dir}</h3>";
            try {

                $files = new RecursiveDirectoryIterator($dir);
                foreach (new RecursiveIteratorIterator($files, RecursiveIteratorIterator::LEAVES_ONLY) as $filename => $cur) {
                    if ($fileName . '.php' == $cur->getFileName()) {
                        return $cur->getFileInfo();
                    }
                }
            } catch (UnexpectedValueException $e) {
                //if you get here it most likely means that the function tried searching a directory that does not exist.
                continue;
            }
        }
        return FALSE;
    }


    public static function redirect($url, $exit = true) {
        if (!empty($url)) {
            header("Location:" . $url);
            if ($exit) {
                exit();
            }
        }
    }
}

/**
 * class auto loader
 *
 * @todo Deal with multiple _autoload functions.
 */
function __autoload($className) {
    $class = Site::findFile($className, Site::$classPaths);
    if ($class) {
        require_once $class;
        return TRUE;
    }
    return FALSE;
}

?>
