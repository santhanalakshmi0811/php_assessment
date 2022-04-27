<?php
session_start();

// For database access
require_once "dbclass.php";
$db = new DB();

// For search flow
$selqry_def = "SELECT * FROM tblproduct ORDER BY prod_name asc";
if (!empty($_POST)){
    
    if($_POST['cat_change']=='all'){
       $selqry = $selqry_def;
    }
    if($_POST['prod_search']!=''){
        $selqry = "SELECT * FROM tblproduct WHERE prod_name like '%".$_POST['prod_search']."%' ORDER BY prod_name asc";
    }
    if($_POST['cat_change']!='all'){
        $selqry = "SELECT * FROM tblproduct WHERE category ='".$_POST['cat_change']."' ORDER BY prod_name asc";
    }           
    if($_POST['show_all']!=''){
        $selqry = $selqry_def;
    }

}
else{
    $selqry = $selqry_def;
}

?>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <link rel='stylesheet' type='text/css' href='css/style.css' />
        <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css' />
        <title>Product listing page</title>
        <script>
        $(document).ready(function() {
	    $('#tbl_product').DataTable( {
               "sDom": '<"top"flp>rt<"bottom"i><"clear">',
               "pageLength" : 5,
               "ordering": false,
               "info":     false,
               "searching": false,
               "lengthChange": false
            } );  
	} );

        </script>
    </head>
    <body>
         <div class='row'>
             <div class="column left">
               <!---- Filter section start  -------------------->
                <form method="post" name="frm_search" id="frm_search" action="<?php echo $_SERVER[‘PHP_SELF’];?>">
                 <table>
                     <tr>
                         <td><input type="search" name="prod_search" id="prod_search" value="<?php echo $_POST['prod_search'];?>"></td>
                         <td>
                            <?php
                            if($_POST['show_all']!='')
                                  $_POST['cat_change'] = 'all';
                            ?>
                            <select name="cat_change" id="cat_change">
                                <option value='all' <?php echo $_POST['cat_change']=='all'?'selected':'';?>>All categories</option>
                                <option value='electronics' <?php echo $_POST['cat_change']=='electronics'?'selected':'';?> >Electornics</option>
                                <option value='clothes' <?php echo $_POST['cat_change']=='clothes'?'selected':'';?> >Clothes</option>
                                <option value='appliances' <?php echo $_POST['cat_change']=='appliances'?'selected':'';?> >Appliances</option>
                                <option value='accessories' <?php echo $_POST['cat_change']=='accessories'?'selected':'';?>>Accessories</option>
                            </select>
                         </td>
                         <td>
                             <input type="button" id="btn_search" value="SEARCH">
                         </td>
                         <td>
                             <input type="button"  id="btn_show_all" value="SHOW ALL">
                             <input type="hidden" name="show_all" id="show_all" value="">
                         </td>
                     </tr>
                 </table>
                 </form>
                 <!----  Filter section end   ---->

                 <!----  Show product list start   ----->
                 <table id="tbl_product">
                     <thead>
		          <tr>
                              <th>PRODUCT</th>
	                      <th>SKU</th>
	                      <th>PRICE</th>
                              <th>Quantity</th>
	                      <th>ACTION</th> 
                          </tr>
                     </thead>
                     <tbody>
                     <?php
                      foreach($db->runQuery($selqry) as $row) {
                         $prod_id = $row['prod_id'];
                      ?>
                                                   
                           <tr>
                              <td class='cls_prod'>
                                  <a href="pdp.php?id=<?php echo $prod_id;?>">
                                      <span><img src="images/<?php echo $row['img_url'];?>" width="50" height="50">
                                      <?php echo $row['prod_name'];?></span>
                                   </a>
                              </td>
                              <td>
                                 <span id="<?php echo 'sku_'.$prod_id;?>"> 
                                     <?php echo $row['sku'];?>
                                 </span>
                              </td>
                              <td>
                                  <span>$</span>
                                  <span id="<?php echo 'price_'.$prod_id;?>">
                                      <?php echo $row['price'];?>
                                  </span>
                              </td>
                              <td>
                                  <input type="number" min="1" max="1000" value="1" id="<?php echo 'qty_'.$prod_id;?>" class="num_input">
                              </td>
                              <td>
                                  <input type="button" value="ADD TO CART" onclick="add_to_cart(<?php echo $prod_id;?>);">
                              </td>
                          </tr>
                     <?php
                     }
                     ?>
                     </tbody>
                 </table>
                 <!--- Show product list end    ------>

                 <!----  hidden form for add to cart function      ------>
                 <form name="frm_add" id="frm_add" method="post" action="post.php">
                     <input type="hidden" name="prodid" id="prodid">
                     <input type="hidden" name="qty" id="qty">
                     <input type="hidden" name="mode" id="mode">
                 </form>
                 <!--- hidden form end    ------>
             </div>

             <!--   view cart start  ------>
             <div class="column right">
                 <?php
                 if(!empty($_SESSION["cart_item"])) {
                 ?>
                     <h3>CART</h3>
                     <table>
                     <?php
                     foreach ($_SESSION['cart_item'] as $cart){
                         echo "<tr>";
                             echo "<td><img src=images/".$cart['image']." width=50 height=50></td>";
                             echo "<td>".$cart['name']."</td>";
                             echo "<td>".$cart['quantity']."x$".$cart['price']."</td>";
                             echo "<td><button onclick=remove_cart(".$cart['code'].")>X</button></td>";
                          echo "</tr>";
                          $cart_price = $cart['quantity']*$cart['price'];
                          $totprice+=$cart_price;
                     }
                     ?>
                      </table>
                     <?php
                     echo 'Subtotal: $'.$totprice;
                  }
                  ?>
             </div>
             <!--- view cart end ---->
         </div>
    </body>
</html>

