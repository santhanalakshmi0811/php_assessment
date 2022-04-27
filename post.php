<?php
session_start();

// for databaase access
require_once "dbclass.php";
$db = new DB();

// add to cart section
if($_POST['mode']=='add'){
    $prodid = $_POST['prodid'];
    $qty = $_POST['qty'];
    if($qty>1000)
        $qty = 1000;
    $prod_data = $db->runQuery("SELECT * FROM tblproduct where prod_id=$prodid");
    $prod_arr = array($prod_data[0]["prod_id"]=>array('name'=>$prod_data[0]["prod_name"], 'code'=>$prod_data[0]["prod_id"], 
                      'quantity'=>$qty, 'price'=>$prod_data[0]["price"], 'image'=> $prod_data[0]['img_url']));
    if(!empty($_SESSION["cart_item"])) {
        if(in_array($prod_data[0]["prod_id"],array_keys($_SESSION["cart_item"]))) {
            foreach($_SESSION["cart_item"] as $key => $val) {
	        if($prod_data[0]["prod_id"] == $key) {
	            if(empty($_SESSION["cart_item"][$key]["quantity"])) {
		        $_SESSION["cart_item"][$key]["quantity"] = 0;
		     }
                     $_SESSION["cart_item"][$key]["quantity"] += $qty;
		}
	    }
        }
        else {
             $_SESSION["cart_item"] = $_SESSION["cart_item"]+$prod_arr;
       }
    }
    else
    {
        $_SESSION["cart_item"] = $prod_arr;
    }
    
}


// remove cart section
if($_POST['mode']=='remove'){
    if(!empty($_SESSION["cart_item"])) {
        foreach($_SESSION["cart_item"] as $key => $val) {
	    if($_POST["prodid"] == $key){
	        unset($_SESSION["cart_item"][$key]);
	     }
	     if(empty($_SESSION["cart_item"])){
	         unset($_SESSION["cart_item"]);
	      }
	  }
     }
    
}
header("Location: plp.php");
exit();


