<?php

namespace App\Helper;

class LicenseKeyGen
{
    public function gen_product_key()
    {
        $keylen = 16; // recommended lengths 8,10,12,14,16,20
        $basechar = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'; //32 symbols
        $formatstr = '4444'; //characters in each segment, max 5 segments
        $isvalid = 'YES'; //returns this value for valid keys
        $invalid = 'NO'; //returns this value for invalid keys
        $software = ''; //name of software for which key is to be generated

        function codeGenerate($name = '')
        {
            $keylen = $this->keylen;
            $initlen = $this->initLen();
            $initcode = $this->initCode($initlen);
            $fullcode = $this->extendCode($initcode, $name);

            return $this->formatLicense($fullcode);
        }

        function codeValidate($serial, $name = '')
        {
            //return false on empty serial
            if (empty($serial) || $serial == '') {
                return $this->invalid;
            }
            //remove formating to get plain string
            $serial = str_replace('-', '', $serial);
            $serial = strtoupper($serial);
            $serial = str_replace(['0', '1', 'O', 'I'],
                ['', '', '', ''],
                $serial);
            $keylen = $this->keylen; //default length
            $thislen = strlen($serial);
            //check length of code
            if ($keylen != $thislen) {
                return $this->invalid;
            }
            $initlen = $this->initLen();
            $initcode = substr($serial, 0, $initlen);
            $extendedcode = $this->extendCode($initcode, $name);
            $fullcode = substr($extendedcode, 0, $keylen);
            if ($fullcode == $serial) {
                return $this->isvalid;
            } else {
                return $this->invalid;
            }
        }

        function initCode($length = 14)
        {
            $list = $this->basechar;
            $lenlist = strlen($list) - 1; //count start from 0
            $codestring = '';
            $length = max($length, 1);
            if ($length > 0) {
                while (strlen($codestring) < $length) {
                    $codestring .= $list[mt_rand(0, $lenlist)];
                }
            }

            return $codestring;
        }

        function extendCode($initcode, $name)
        {
            $software = $this->software;
            $p1str = $this->sumDigit($initcode);
            $p1str .= $this->add32($initcode, $name.'abhishek'.$software);
            $p1str = strtoupper($p1str);
            $p1str = str_replace(['0', '1', 'O', 'I'],
                ['', '', '', ''],
                $p1str);
            $p1len = strlen($p1str);
            $extrabit = '';
            $i = 0;
            while (strlen($extrabit) < $this->keylen - 2) {
                $extrabit .= substr($p1str, $i, 1);
                $extrabit .= substr($p1str, $p1len - $i - 1, 1);
                $i++;
                if (defined('LKM_DEBUG')) {
                    echo "$p1str $extrabit<br/>";
                }
            }

            return $initcode.$extrabit.'6F75';
        }

        function formatLicense($serial)
        {
            $farray = str_split($this->formatstr);
            $sarray = str_split($serial);
            $s0 = $farray[0];
            $s1 = $farray[1] + $s0;
            $s2 = $farray[2] + $s1;
            $s3 = $farray[3] + $s2;
            $s4 = $farray[3] + $s3;
            $scount = $this->keylen;
            $sformated = '';
            for ($i = 0; $i < $scount; $i++) {
                if ($i == $s0 || $i == $s1 || $i == $s2 || $i == $s3 || $i == $s4) {
                    $sformated .= '-';
                }
                $sformated .= $sarray[$i];
            }
            if (defined('LKM_DEBUG')) {
                echo " $serial FORMATED AS $sformated<br/>";
            }

            return $sformated;
        }

        function initLen()
        {
            $keylen = $this->keylen;
            $initlen = intval($keylen / 3);
            $initlen = max($initlen, 1);

            return $initlen;
        }

        function add32($a, $b)
        {
            $sum = base_convert($a, 36, 10) + base_convert($b, 36, 10);
            $sum32 = base_convert($sum, 10, 36);
            $sum32 = str_replace(['0', '1', 'O', 'I', 'o', 'i'],
                ['', '', '', '', '', ''],
                $sum32);
            if (defined('LKM_DEBUG')) {
                echo " ADD32 $a + $b = $sum32<br/>";
            }

            return $sum32;
        }

        function sumDigit($str)
        {
            $a = str_split($str);
            $sum = 0;
            for ($i = 0; $i < count($a); $i++) {
                $sum = $sum + base_convert($a[$i], 36, 10);
            }
            $sum = str_replace(['0', '1', 'O', 'I', 'o', 'i'],
                ['AZ', 'BY', '29', '38', '29', '38'],
                $sum);
            if (defined('LKM_DEBUG')) {
                echo " sumDigit  $str = $sum<br/>";
            }

            return $sum;
        }
    }
}
