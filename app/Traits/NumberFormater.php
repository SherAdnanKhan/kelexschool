<?php

namespace App\Traits;


trait NumberFormater
{
    public function numberFormat($number)
    {
            $formatedNumber = "";
            if (preg_match("/^[03].[0-9]{9}$/", $number)) {
                $formatedNumber = '92' . substr($number, 1);

            } elseif (preg_match("/^[92].[3].[0-9]{8}$/", $number)) {
                $formatedNumber = $number;

            } elseif (preg_match("/^[+][92].[3][0-9]{9}$/", $number)) {
                $formatedNumber = '92' . substr($number, 1);

            } elseif (preg_match("/^[3][0-9]{9}$/", $number)) {
                $formatedNumber = '92' . $number;

            } else {
                $formatedNumber = '';

            }
            return $formatedNumber;
        }

}
?>
