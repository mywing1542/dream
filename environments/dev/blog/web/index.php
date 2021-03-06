<?php
if (isset($_GET['a']) || isset($_GET['c'])) {
    header('HTTP/1.1 404 Not Found');
    header("status: 404 Not Found");
    exit();
}

//www
if (isset($_SERVER['REQUEST_URI']) && preg_match("/^\/default\/\d+$/", $_SERVER['REQUEST_URI'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: {$_SERVER['REQUEST_URI']}.html");
    exit();
}
//module wap
if (isset($_SERVER['REQUEST_URI']) && preg_match("/^\/wap\/default\/\d+$/", $_SERVER['REQUEST_URI'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".str_replace("/wap","",$_SERVER['REQUEST_URI']).".html");
    exit();
}

header("Cache-control:no-cache,no-store,must-revalidate");
header("Pragma:no-cache");
header("Expires:0");
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

/*定义版本号变量*/
if(file_exists("/data/www/version_blog")){
    define("RELEASE_VERSION",trim( trim(file_get_contents("/data/www/version_blog")) ));
}else{
    define("RELEASE_VERSION",time());
}

if(file_exists("/home/vagrant/release/dream") ){
    header("vincentguo: ".trim(file_get_contents("/home/vagrant/release/dream") ) );
}


$application = new yii\web\Application($config);
$application->run();
