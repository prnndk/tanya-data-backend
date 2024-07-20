<?php

namespace App\Enums;

enum ValidateStatusType: string
{
    case ACCEPTED = "Accepted";
    case REJECTED = "Rejected";
    case REVISION = "Revision";
}
