<?php

/**
 * Created by PhpStorm.
 * User: Phillip Madsen
 * Date: 7/11/2016
 * Time: 3:46 PM
 */
function generateSku() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $sku = mt_rand(10000, 99999) . mt_rand(10000, 99999) . $characters[mt_rand(0, strlen($characters) - 1)];
    return str_shuffle($sku);
}

function generatePin() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pin = mt_rand(10000, 99999) . mt_rand(10000, 99999) . $characters[mt_rand(0, strlen($characters) - 1)];
    return str_shuffle($pin);
}

function generateCoupon() {
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $coupon = "";
    for ($i = 0; $i < 6; $i++) {
        $coupon .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
}

function generateModel() {

    $num_of_ids = 10000; //Number of "ids" to generate.
    $i = 0; //Loop counter.
    $n = 0; //"id" number piece.
    $l = "AAA"; //"id" letter piece.

    while ($i <= $num_of_ids) {
        $id = $l . sprintf("%04d", $n); //Create "id". Sprintf pads the number to make it 4 digits.
        echo $id . "<br>"; //Print out the id.

        if ($n == 9999) { //Once the number reaches 9999, increase the letter by one and reset number to 0.
            $n = 0;
            $l++;
        }

        $i++;
        $n++; //Letters can be incremented the same as numbers. Adding 1 to "AAA" prints out "AAB".
    }
}

// The previous code would print out the following, AAA0000 AAA0001 AAA0002 AAA0003 AAA0004 AAA0005 AAA0006 AAA0007


function outputProducts()
    {
        $products = Product::all();
        $string = "<ul>";
        foreach ($products as $i => $product) {
            $string .= "<li>";
            $string .= $product['name'];
            if (count($product['children'])) {
                $string .= $this->output($product['children']);
            }
            $string .= "</li>";
        }
        $string .= "</ul>";
        return $string;
    }



function SKU_gen($string, $id = null, $l = 2){
    $results = ''; // empty string
    $vowels = array('a', 'e', 'i', 'o', 'u', 'y'); // vowels
    preg_match_all('/[A-Z][a-z]*/', ucfirst($string), $m); // Match every word that begins with a capital letter, added ucfirst() in case there is no uppercase letter
    foreach($m[0] as $substring){
        $substring = str_replace($vowels, '', strtolower($substring)); // String to lower case and remove all vowels
        $results .= preg_replace('/([a-z]{'.$l.'})(.*)/', '$1', $substring); // Extract the first N letters.
    }
    $results .= '-'. str_pad($id, 4, 0, STR_PAD_LEFT); // Add the ID
    return $results;

}



