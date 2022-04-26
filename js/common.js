$(function(){
    $('#btn_search').click(function(){
        $('#frm_search').submit();
    });
    $('#btn_show_all').click(function(){
        $('#show_all').val('show_all');
        $('#frm_search').submit();
    });
    $('#cat_change').change(function(){
        $('#prod_search').val('');
        $('#frm_search').submit();
    });


});

function add_to_cart(prodid)
{
   var qty   = $('#qty_'+prodid).val();
   $('#prodid').val(prodid);
   $('#mode').val('add');
   $('#qty').val(qty);
   $('#frm_add').submit();
}

function remove_cart(id)
{
    $('#prodid').val(id);
    $('#mode').val('remove');
    $('#frm_add').submit();

}
