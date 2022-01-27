<?php
spl_autoload_register(function ($className) {
    echo $className;
    $firstSlash = strpos($className, '\\');
    echo '<br>'.$firstSlash;
    $className = substr($className, $firstSlash);
    echo '<br>'.$className;
    $directory = __DIR__.'/'.$className.'.php';
    echo '<br>'.$directory;
    $fileName = str_replace('\\', '/', $directory);
    echo '<br>'.$fileName;
    require_once($fileName);
});