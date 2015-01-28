<?php
#!/usr/bin/php -q
/*ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 1200);*/
require_once 'uploadHelper.php';
require_once 'config.php';
cron();


/*
* This is a daily report function
*/
function cron()
{
    echo date("Y-m-d H:i:s", time()) . '  ';
    $uploadDir = APPLICATION_UPLOAD_DIR;
    $backupDir = APPLICATION_BACKUP_DIR;
    $upload = new Upload();
    $fileName = $upload->getFile($uploadDir);
    if($fileName){
        $uploadFile = $upload->renameFile($fileName, $uploadDir);
        $result = $upload->ftpUpload($uploadFile);
        if($result){
            $upload->backupFile($uploadFile, $backupDir);
            echo 'done.';
        }
        else
            echo 'FTP error.';
    } else {
        echo 'Get file error.';
    }
    echo '\n';
}