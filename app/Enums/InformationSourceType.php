<?php

namespace App\Enums;

enum InformationSourceType:string{
    case INSTAGRAM = "Instagram";
    case WHATSAPP = "Whatsapp";
    case GURU_DOSEN = "Guru/Dosen";
    case TEMAN = "Teman";
    case SUMBER_LAIN = "Sumber Lain";
}
