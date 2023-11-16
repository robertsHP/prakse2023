<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FileUpload.php';

    //Māsīvs iekšā $_SESSION, kas glabā datus īslaicīgai izmantošanai

    if(session_status() !== PHP_SESSION_NONE) {
        $currentPageName = baseName($_SERVER['PHP_SELF']);

        if(!isset($_SESSION['temp'])) {
            $_SESSION['temp'] = [
                'pageName' => baseName($_SERVER['PHP_SELF']),
                'paths' => []
            ];
        } else if ($_SESSION['temp']['pageName'] != $currentPageName) {
            $_SESSION['temp']['pageName'] = $currentPageName;

            foreach ($_SESSION['temp']['paths'] as $filePath) {
                $filePath = $_SERVER['CONTEXT_DOCUMENT_ROOT'].$filePath;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $_SESSION['temp']['paths'] = [];
        }
    }
?>