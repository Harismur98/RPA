<?php

namespace App\Enums;

enum ConditionType: string
{
    case ELEMENT_EXISTS = 'element_exists';
    case TEXT_FOUND = 'text_found';
    case COUNT = 'count';
    case UNTIL_NOT_FOUND = 'until_not_found';
} 