<?php
namespace App\Enums;
enum AuthorizationStateEnum : string{
    case ACCEPTED = "ACCEPTED";
    case REJECTED = "REJECTED";
    case SENDED = "SENDED";
}