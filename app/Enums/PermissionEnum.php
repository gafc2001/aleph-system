<?php
namespace App\Enums;

enum PermissionEnum : string {
    case PERMISO_PERSONAL = 'PERMISO_PERSONAL';
    case SOLICITUD_HORAS_EXTRAS = 'SOLICITUD_HORAS_EXTRAS';
    case TRABAJO_CAMPO = 'TRABAJO_CAMPO';
    case COMPENSACION = 'COMPENSACION';
}