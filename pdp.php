<?php
/*$user = "root";
$password = "Admin@123";
$database = "php_assignment";
$table = "tblproduct";
$db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);*/

require_once "dbclass.php";
$db = new DB();
$prodid =  $_GET['id'];
$prod_data = $db->runQuery("SELECT * FROM tblproduct where prod_id=$prodid");

?>

<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <link rel='stylesheet' type='text/css' href='css/style.css' />
        <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css' />
        <title>Product detail page</title>
        
    </head>
    <body>
        <h1><?php echo $prod_data[0]['prod_name'];?></h1>
        <img src="images/<?php echo $prod_data[0]['img_url'];?>" width="500" height="500"><br>
        <h2>SKU:</h2><?php echo $prod_data[0]['sku'];?><br>
        <h2>Product description:</h2><?php echo $prod_data[0]['prod_description'];?><br><br><br>
        <input type="number"  min="1" max="1000" value="1" id="<?php echo 'qty_'.$prodid;?>" class="num_input">
        <input type="button" value="ADD TO CART" onclick="add_to_cart(<?php echo $prodid;?>);">
        <form name="frm_add" id="frm_add" method="post" action="post.php">
            <input type="hidden" name="prodid" id="prodid">
            <input type="hidden" name="qty" id="qty">
            <input type="hidden" name="mode" id="mode">
        </form>

        
    </body>
</html> 



