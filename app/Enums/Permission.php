<?php
namespace App\Enums;

enum Permission : string {
    case PERMISO_PERSONAL = 'PERMISO_PERSONAL';
    case SOLICITUD_HORAS_EXTRAS = 'SOLICITUD_HORAS_EXTRAS';
    case TRABAJO_CAMPO = 'TRABAJO_CAMPO';
    case COMPENSACION = 'COMPENSACION';
}