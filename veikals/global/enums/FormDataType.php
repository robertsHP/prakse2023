<?php
    enum FormDataType : int {
        case TEXT = 0;
        case NUMBER = 1;
        case DECIMAL = 2;
        case FILE = 3;
        case EMAIL = 4;
        case PHONE_NUMBER = 5;
        case DATE = 6;
    }
?>