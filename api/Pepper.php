<?php 
namespace app\api;

use app\api\Configpass;

class pepper
{
    public static function pepper($str, $dbhash, $debug = 0) { // str = string to be checked against DBHASH
       // global $saltkey,$config;
//        $saltkey = $config['saltkey'];
        $setconfig = Configpass::setpass();
        $config['saltkey']	= $setconfig;


        $saltkey = $config['saltkey'];
        // Find the original sha1 hash  and check it with the new one
        $hashA = sha1($str); // new hash to be checked
        
        $pos = substr($dbhash, -2);
        
        $stype = substr($dbhash, -3, 1); // n or b
        
        if ($stype == 'n') {
            $slen = 40;
        } else {
            $slen = 32;
        }
        
        $beforesalt = substr($dbhash, 0, $pos);
        
        $aftersaltA = substr($dbhash, ($pos + $slen));
        
        $aftersalt = substr($aftersaltA, 0, -3);
        
        $saltA = substr($dbhash, $pos, ((-strlen($aftersalt)) - 3));
        
        if ($stype == 'n') {
            $salt = sha1($saltkey);
        } else {
            $salt = md5($saltkey);
        }
        
        $unsalted = $beforesalt . $aftersalt;
        
        if ($debug == 1) {
        echo '<br><br>$saltkey = '.$saltkey;
        echo '<br>$str = '.$str;
        echo '<br>$dbhash = '.$dbhash;
        echo '<br>$hashA = '.$hashA;
        echo '<br>$pos = '.$pos;
        echo '<br>$stype = '.$stype;
        echo '<br>$slen = '.$slen;
        echo '<br>$beforesalt = '.$beforesalt;
        echo '<br>$aftersaltA = '.$aftersaltA;
        echo '<br>$aftersalt = '.$aftersalt;
        echo '<br>$saltA = '.$saltA;
        echo '<br>$salt = '.$salt;
        echo '<br>$unsalted = '.$unsalted.'<br>if = ';

        }
        
        if (($hashA == $unsalted) && ($salt == $saltA)) {
            if ($debug == 1): echo 'true'; endif;
            return true;
        } else {
            if ($debug == 1): echo 'false'; endif;
            return false;
        }
    }
}

?>