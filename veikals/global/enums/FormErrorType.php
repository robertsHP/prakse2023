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
        case FILE_NOT_FOUND = 8;
        case FILE_COULDNT_BE_MOVED = 9;
        case FILE_INFO_PASSAGE_INVALID = 10;

        case DATE_INVALID = 11;

        case PHONE_NUMBER_INVALID = 20;
    }
    class FormTypeErrorConditions {
        public const INPUT_FAIL_DEFAULT = [

        ];
        public const FILE_DEFAULT = [
            FormErrorType::EMPTY->value                     => 'Fails nav pievienots',
            FormErrorType::FILE_ALREADY_EXISTS->value       => 'Fails jau eksistē',
            FormErrorType::FILE_TOO_LARGE->value            => 'Fails ir pārāk liels',
            FormErrorType::FILE_FORMAT_INCORRECT->value     => 'Faila formāts nav pareizs',
            FormErrorType::FILE_UPLOAD_UNSUCCESSFUL->value  => 'Faila augšupielāde nebija veiksmīga',
            FormErrorType::FILE_NOT_FOUND->value            => 'Fails nebija atrasts',
            FormErrorType::FILE_COULDNT_BE_MOVED->value     => 'Failu nevarējā pārcelt',
            FormErrorType::FILE_INFO_PASSAGE_INVALID->value     => 'Padotā faila informācija ir nepareiza'
        ];
        public const EMAIL_DEFAULT = [
            FormErrorType::EMPTY->value => 'E-pasts ir nepieciešams',
            FormErrorType::EMAIL_INVALID->value => 'E-pasts nav pareizi ievadīts'
        ];
        public const DATE_DEFAULT = [
            FormErrorType::EMPTY->value => 'Datums nav norādīts',
            FormErrorType::DATE_INVALID->value => 'Datums nav pareizi norādīts'
        ];
        public const PHONE_NUMBER_DEFAULT = [
            FormErrorType::EMPTY->value => 'Telefona numurs ir nepieciešams',
            FormErrorType::PHONE_NUMBER_INVALID->value => 'Telefona numurs nav pareizi ievadīts'
        ];
    }
?>