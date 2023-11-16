<?php
    //Māsīvs iekšā $_SESSION, kas glabā datus īslaicīgai izmantošanai

    if(session_status() !== PHP_SESSION_NONE) {
        $currentPageName = baseName($_SERVER['PHP_SELF']);

        if(!isset($_SESSION['temp'])) {
            $_SESSION['temp'] = [
                'pageName' => baseName($_SERVER['PHP_SELF']),
                'filePaths' => []
            ];
        } else if ($_SESSION['temp']['pageName'] != $currentPageName) {
            $_SESSION['temp']['pageName'] = $currentPageName; 
            $_SESSION['temp']['filePaths'] = [];  
        }
    }
?>