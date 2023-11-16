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
?>