<?php
    enum FormErrorType : int {
        case NONE = 0;
        case EMPTY = 1;
        case EMAIL_INVALID = 2;
        
        case FILE_ALREADY_EXISTS = 3;
        case FILE_TOO_LARGE = 4;
        case FILE_FORMAT_INCORRECT = 5;
        case FILE_IS_NOT_AN_IMAGE = 6;
        case FILE_UPLOAD_UNSUCCESSFUL = 7;
    }

    function getFileErrorTypes () {
        return [
            FormErrorType::EMPTY->value                     => 'Fails nav pievienots',
            FormErrorType::FILE_ALREADY_EXISTS->value       => 'Fails jau eksistē',
            FormErrorType::FILE_TOO_LARGE->value            => 'Fails ir pārāk liels',
            FormErrorType::FILE_FORMAT_INCORRECT->value     => 'Faila formāts nav pareizs',
            FormErrorType::FILE_IS_NOT_AN_IMAGE->value      => 'Fails nav bilde',
            FormErrorType::FILE_UPLOAD_UNSUCCESSFUL->value  => 'Faila augšupielāde nebija veiksmīga'
        ];
    }
?>