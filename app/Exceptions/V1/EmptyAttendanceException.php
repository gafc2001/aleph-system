<?php

namespace App\Exceptions\V1;

use Exception;

class EmptyAttendanceException extends Exception
{
    public function context(){
        return ["message" => "no data"];
    }
}
