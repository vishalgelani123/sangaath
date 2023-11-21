<?php
    function IndianNumberComma($number)
    {
            $decimal = (string)($number - floor($number));
            $number = floor($number);
            $length = strlen($number);
            $m = '';
            $number = strrev($number);
            for($i=0;$i<$length;$i++){
                if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                    $m .=',';
                }
                $m .=$number[$i];
            }
            $result = strrev($m);
            $decimal = preg_replace("/0\./i", ".", $decimal);
            $decimal = substr($decimal, 0, 3);
            if( $decimal != '0'){
            $result = $result.$decimal;
            }
            return $result;
        }
?>