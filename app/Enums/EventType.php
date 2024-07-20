<?php

namespace App\Enums;

enum EventType: string
{
    case TALKS = "Talks";
    case OPENCLASS = "Class";
    case COACHING = "Coaching";
}
