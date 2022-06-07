<?php
if (! function_exists('generateCode')) {
    function generateCode(){
        $date = date("YmdHis");
        return substr(hash("sha256",$date),0,10);
    }
}
