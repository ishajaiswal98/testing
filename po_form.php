<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include_once 'include/functions.php';
include_once('include/user.php');
include_once 'include/connect.php';
include_once 'dbCon.php';
include_once 'dbConfig.php';
if(login_check(dbConnect()) == true) {
    if (isset($_POST['next'])) {
    $countryName = $_POST['v_contactnm'];
    $sql = 'SELECT * FROM vendor_table
    WHERE vendorCode = :supplierCode';
    $stmt = $connect->prepare($sql);
    $stmt->execute(['supplierCode' => $countryName]);
    $row_ven = $stmt->fetch();
  }
        // Add your protected page content here!
        $id_query = " SELECT d.id,d.orderno FROM `po_form` as d";
        $id_result = mysqli_query($db,$id_query);
         while($rowid = mysqli_fetch_assoc($id_result)){
             $po_id = $rowid['orderno'];
             $po_id ++;
 }
        if(isset($_POST['btn_save'])){
            date_default_timezone_set('Asia/Kolkata');
    $date1 = "";
    $date = date_create($date1, timezone_open('Pacific/Nauru'));
    date_format($date, 'Y-m-d H:i:s') . "\n";
    date_timezone_set($date, timezone_open('Asia/Calcutta'));
    $final_date =  date_format($date, 'Y-m-d H:i:s') . "\n"; 
    
    $v_name = $_POST['v_contactnm'];
    $v_client = $_POST['v_contactnm'];
    $v_address = $_POST['v_address']; 
    $v_phone = $_POST['v_phone'];
    $s_contactnm = $_POST['s_contactnm'];
    $s_clientcompnm = $_POST['s_clientcompnm'];
    $s_address = $_POST['s_address'];
    $s_phone = $_POST['s_phone'];
    $orderno = $_POST['orderno'];
    $remark = $_POST['remark'];
    $subtotal = $_POST['subtotal'];
    $discount = $_POST['discount']; 
    $total_disc = $_POST['total_disc'];
    $tax_rate = $_POST['tax_rate'];
    $total_tax = $_POST['total_tax'];
    $total_amt = $_POST['total_amt'];
    $shipping = $_POST['shipping'];
    $createdon = $final_date;
    $userid = $_SESSION['userid'];
    
   
     $sql_insert ="INSERT INTO `po_form`(`orderno`,`ven_contactnm`,`ven_client_comp`,`ven_addr`,`phone`, `shipped_dept`, `shipped_comp_nm`, 
     `shipped_addr`, `shipped_phn`, `createdon`,`remarks`,`subtotal`,`discount`,`less_discount`,`taxrate`,`totaltax`,`shipping`,`total`,`userid`) 
                    VALUES ('$orderno','$v_name','$v_client','$v_address','$v_phone','$s_contactnm','$s_clientcompnm',
                    '$s_address','$s_phone','$createdon','$remark','$subtotal','$discount','$total_disc','$tax_rate','$total_tax','$shipping','$total_amt','$userid')";     
    $res_insert = mysqli_query($db, $sql_insert);
     extract($_POST);
     $service = count($_POST['code']);
 for($i=0;$i<$service;$i++){   
  $sql_service = "INSERT INTO `po_form_1`(`code`,`mainId`,`product`,`qty`,`unit`,`total`,`createdon`,`userid`) VALUES('$code[$i]','$po_id','$select_services[$i]','$quantity[$i]',$unit_price[$i],'$total[$i]','$final_date','$userid')"; 
  $result1 = mysqli_query($db,$sql_service);
    header('location:/po_form?po=form_display');
   
        }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Purchase Order Details | Market99</title>
  <link rel="icon" href="images/logo1.png" type="image/ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="./plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="./plugins/parsley/parsley.css" />
</head>
<style>
.form-control {
    height: auto;
}
.select2-container--default .select2-results__group {
    cursor: default;
    display: block;
    padding: 6px;
    border: 2px solid darkviolet;
    text-align: center;
    background-color:greenyellow;
}
  .hide
  {
    display: none;
  }
  .form-control.name{
    border: 0px;
    border-bottom: 1px solid black !important;
  }.form-control.vendor{
    border: 0px;
    height: calc(1rem + -1px);
  }
  hr {
     margin-top: 0; 
    margin-bottom: 1rem;
    border: 0;
    border-top: 2px solid #2456A5;
}
</style>

 
 <?php include_once('include/top_bar.php'); ?>
 <?php include('include/doNav.php'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-sm-12">
            </div>
        </div>
    </div>
    <section class="content">
        <?php if(isset($_GET['po']) == 'form_display') { ?>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="./po_form?purchase_order=order_display" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">CONTACT NAME</label>
                                      <div class="col-sm-5">
                                          <select class="form-control name" name="v_contactnm" id="v_contactnm" required>
                                              <option value="select option">---Select Vendor Name---</option>
                                              <?php 
                                            $vendor_query = mysqli_query($db,"SELECT DISTINCT(`supplierName`),supplierCode FROM `m99itemmaster` WHERE `supplierName` != ''");
                                            while($rowven = mysqli_fetch_assoc($vendor_query)){ 
                                            $suppliercode = $rowven['supplierCode'];
                                            $supplierName = $rowven['supplierName'];
                                            ?>
                                            
                                                <option value="<?php echo $rowven['supplierCode'];?>"><?php echo $rowven['supplierName']; ?></option>
                                          <?php } ?>
                                          </select>
                                          <!--<input class="form-control name" type="text" name="v_contactnm" data-parsley-trigger="keyup" required>-->
                                      </div>                
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <input type="submit" name="next" class="btn btn-sm btn-block btn-primary" value="Next" required />
                                        </div>
                                    </div>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php }elseif(isset($_GET['purchase_order']) == 'order_display') { ?>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                   <div class="card">
                       
                       
                        <div class="card-body">
                            <?php 
                                 $query = mysqli_query($db,"select * from compDetail");
                                 while($row = mysqli_fetch_assoc($query)){
                                    
                                ?>
                            <form method="POST" action="./po_form?purchase_order=order_display" data-parsley-validate>
                                <div class="row">
                                    <div class="col-md-5 col-sm-5">
                                        <div class="form-group row mt-2">
                                            <img src="<?php echo $row['logo']; ?>" height ="45" width="200">
                                        </div>
                                        <div class="form-group row">
                                            
                                      <label class="col-md-3 col-sm-3">Company Name:</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="companynm" value="<?php echo $row['Comp_name']; ?>">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-3 col-sm-3">Address:</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="address" value="<?php echo $row['address']; ?>">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-3 col-sm-3"></label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" value="<?php echo $row['city']."," . $row['state']."-" .$row['pincode']; ?>">
                                      </div>
                                    </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                    <div class="form-group row mt-2">
                                        <h4 class="font-weight-bold">Purchase Order</h4>
                                        </div>
                                        <div class="form-group row">
                                      <label class="col-md-3 col-sm-3"></label>
                                      <div class="col-sm-5">
                                          
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-3 col-sm-3">Date:</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="orderdate" value="<?php echo date("Y/m/d") ?>" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-3 col-sm-3">Order No:</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="orderno" autofocus="" required>
                                      </div>
                                    </div>
                                    </div>
                                </div><br><br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-md-3 col-sm-3">VENDOR:</label>
                                    <hr>
                                    
                                    <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">CONTACT NAME</label>
                                      <div class="col-sm-5">
                                          <select class="form-control name" name="v_contactnm" id="v_contactnm" required>
                                                <option value="">select vendor</option>
                                                <option value="<?php echo $row_ven['vendorCode'];?>"><?php echo $row_ven['vendorCode']; ?></option>
                                          
                                          </select>
                                          <!--<input class="form-control name" type="text" name="v_contactn" value="<?php echo $row_ven['supplierCode']; ?>"  data-parsley-trigger="keyup" required>-->
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">CLIENT COMPANY NAME</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" value="<?php echo $row_ven['companyName']; ?>" name="v_clientcompnm" data-parsley-trigger="keyup" required>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">ADDRESS</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" value="<?php echo $row_ven['companyAddress']; ?>" name="v_address" data-parsley-trigger="keyup" required>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">PHONE</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="v_phone" value="<?php echo $row_ven['companyNumber']; ?>" required data-parsley-type="integer" data-parsley-length="[10,10]" data-parsley-trigger="keyup" data-parsley-type-message="Please enter valid Mobile Number">
                                      </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-md-3 col-sm-3">SHIP TO:</label><hr>
                                    <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">NAME/DEPT</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="s_contactnm" required>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">CLIENT COMPANY NAME</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="s_clientcompnm" required>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">ADDRESS</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="s_address" required>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-md-4 col-sm-4">PHONE</label>
                                      <div class="col-sm-5">
                                          <input class="form-control name" type="text" name="s_phone" required data-parsley-type="digit" data-parsley-length="[10,10]" data-parsley-trigger="keyup" data-parsley-type-message="Please enter valid Mobile Number">
                                      </div>
                                    </div>
                                    </div>
                                
                                </div>
                                <?php } ?>
                                <div class="row table-primary mb-1">
                                    <div class="col-sm-2">
                                            <label>CODE</label>
                                    </div>
                                    <div class="col-sm-2">
                                            <label>PRODUCT NAME</label>
                                    </div>
                                    <div class="col-sm-2">
                                            <label>QTY</label>
                                    </div>
                                    <div class="col-sm-2">
                                            <label>UNIT PRICE</label>
                                    </div>
                                    <div class="col-sm-2">
                                            <label>TOTAL</label>
                                    </div>
                                </div>
                                <div class="mydiv">
                                    <div class="form-group row control-group after-add-more subdiv">
                                        <div class="col-sm-2">
                                            <select class="form-control" id="code" name="code[]" style="width:100%;" required>
                                                <option value="Select Itemcode" disabled="" selected="">Select Itemcode</option>
                                            </select>
                                            <!--<input type="text" class="form-control" id="code" name="code[]" placeholder="code" style="min-width:80px;" required>-->
                                        </div>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="select_services" name="select_services[]" style="width:100%;" required>
                                                <option value="Select product" disabled="" selected="">Select Product</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="quantity" name="quantity[]" placeholder="Qty" required data-parsley-type="integer" data-parsley-trigger="keyup" data-parsley-type-message="Please enter valid Quantity">
                                        </div>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="unit_price" name="unit_price[]" style="width:100%;" required>
                                                <option value="Select Unit Price" disabled="" selected="">Select Unit Price</option>
                                            </select>
                                            <!--<input type="text" class="form-control" id="unit_price" name="unit_price[]" placeholder="Sale Price" required data-parsley-type="number" data-parsley-trigger="keyup" data-parsley-type-message="Please enter valid Price">-->
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control total" id="total" name="total[]" placeholder="Total" readonly="" tabindex="-1">
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-success add-more" type="button"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">REMARKS/NOTES</label>
                                          <div class="col-sm-8">
                                              <textarea type="text" name="remark" id="remark" class="form-control bg-light" placeholder="Remark" rows="8" cols="50" maxlength="250" data-parsley-trigger="keyup" data-parsley-minlength="5" data-parsley-maxlength="800" data-parsley-maxlength-message="Come on! You can enter upto a 800 characters remarks.."></textarea>
                                                <p id="charCount" class = "text-danger">0 Charaters</p> 
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">AUTHORITY SIGNATURE</label></div> 
                                    </div>
                                    <div class="col-sm-6" style="text-align-last: end;">
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">SUBTOTAL</label>
                                          <div class="col-sm-3">
                                              <input type="text" name="subtotal" id="subtotal" class="form-control" placeholder="Subtotal" readonly="" tabindex="-1" onkeyup="add_number()">
                                          </div>
                                        </div> 
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">DISCOUNT</label>
                                          <div class="col-sm-3">
                                              <input type="text" name="discount" id="discount" class="form-control" placeholder="" onkeyup="add_number()" data-parsley-type="number" data-parsley-trigger="keyup" data-parsley-type-message="Please enter valid Discount">
                                          </div>
                                        </div> 
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">SUBTOTAL LESS DISCOUNT</label>
                                          <div class="col-sm-3">
                                              <input type="text" name="total_disc" id="total_disc" class="form-control" readonly="" tabindex="-1" onkeyup="add_number()">
                                          </div>
                                        </div> 
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">TAX RATE</label>
                                          <div class="col-sm-3">
                                              <input type="text" name="tax_rate" id="tax_rate" class="form-control" placeholder="tax rate" onkeyup="add_number()" data-parsley-type="number" data-parsley-trigger="keyup" data-parsley-type-message="Please enter valid Tax Rate">
                                          </div>
                                        </div> 
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">TOTAL TAX</label>
                                          <div class="col-sm-3">
                                              <input type="text" name="total_tax" id="total_tax" class="form-control" placeholder="total tax" readonly="" tabindex="-1" onkeyup="add_number()">
                                          </div>
                                        </div> 
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">SHIPPING/HANDLING</label>
                                          <div class="col-sm-3">
                                              <input type="text" name="shipping" id="shipping" class="form-control" placeholder="shipping" onkeyup="add_number()" data-parsley-type="number" data-parsley-trigger="keyup" data-parsley-type-message="Please enter valid Shipping">
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label class="col-sm-6 control-label">TOTAL</label>
                                          <div class="col-sm-3">
                                              <input type="text" name="total_amt" id="total_amt" class="form-control" placeholder="total" readonly="" tabindex="-1" onkeyup="add_number()">
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>  
                            </form>
                            <div class="copy hide">
                                <div class="form-group control-group row subdiv">
                                    <div class="col-sm-2">
                                        <select class="form-control" id="codes" name="code[]" style="width:100%;" required>
                                            <option value="Select Itemcode" disabled="" selected="">Select Itemcode</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="col-sm-12">
                                           <select class="form-control" id="select_services" name="select_services[]" style="width:100%;" required>
                                                <option value="Select product" disabled="" selected="">Select Product</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="quantity" name="quantity[]" placeholder="Qty">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="unit_prices" name="unit_price[]" placeholder="Sale Price">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control total" id="total" name="total[]" placeholder="Total" readonly="">
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-danger remove" type="button"><i class="fa fa-minus"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </section>
    </div>
<?php include('include/footer.php'); ?>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="dist/js/demo.js"></script>
<script type="text/javascript" src="plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="./plugins/parsley/dist/parsley.min.js"></script>

<script>
  $(function () {
    $("#example").DataTable({
       "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "pagelength": 10,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']],
             initComplete: function () {
            this.api().columns([1,3,4,5]).every( function () {
                  $( select ).click( function(e) {
                  e.stopPropagation();
                  });
                var column = this;
                var select = $('<select class=""><option value="">ALL</option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false ).draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    var val = $('<div/>').html(d).text();
                    select.append( '<option value="' + val + '">' + val + '</option>' );
                } );
            } );
        }
    });
  });
</script>
<script type="text/javascript">
  $(".add-more").on('click',function(){ 

          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });  

      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });   
</script>
<script type="text/javascript">

$(document).ready(function() {
$('div.mydiv').on("keyup",'select[select^="unit_price"]',function(event){
          var currentRow=$(this).closest('.subdiv');
          var quantity =currentRow.find('input[name^="quantity"]').val();
          //alert(quantity);
          var unitprice=currentRow.find('select[select^="unit_price"]').val();
         //alert(unitprice);
        
          var total = Number(quantity) * Number(unitprice);
          var total=+currentRow.find('input[name^="total"]').val(total);
         // $('#subtotal').val(total);
    var sum = 0;
    $('.total').each(function() {
        sum += Number($(this).val());
    });
 $('#subtotal').val(sum);
$('#final_total').val(sum);
var sub_text = $('#subtotal').val();
var disc=$("#view_discount").val();
var sub_total = Number(sub_text)- Number(disc) ; 
$("#final_total").val(sub_total);
     });
     
     $('div.mydiv').on("keyup",'input[name^="quantity"]',function(event){
          var currentRow=$(this).closest('.subdiv');
          var quantity =currentRow.find('input[name^="quantity"]').val();
          //alert(quantity);
          var unitprice=currentRow.find('input[name^="unit_price"]').val();
         //alert(unitprice);
        
          var total = Number(quantity) * Number(unitprice);
          var total=+currentRow.find('input[name^="total"]').val(total);
         // $('#subtotal').val(total);
    var sum = 0;
    $('.total').each(function() {
        sum += Number($(this).val());
    });
 $('#subtotal').val(sum);
$('#final_total').val(sum);

var sub_text = $('#subtotal').val();
var disc=$("#view_discount").val();
var sub_total = Number(sub_text)- Number(disc) ; 
$("#final_total").val(sub_total);

var tot_commi = 0;
});

$('form').on("keyup",'input[name="advanced_amount"]',function(argument) {
var final_total = $('#final_total').val();
//alert(final_total);
var advanced_amount = $(this).val();
//alert(advanced_amount);
if(Number(advanced_amount) >  Number(final_total)){
alert('Your Amount is greater than:'+final_total);
$("#advanced_amount").val("");
}
else {
var cust_amt = Number(final_total)  -  Number(advanced_amount);
//alert(cust_amt);
var cust_pending = $("#pending_amount").val(cust_amt);
}

  });
});


 $('div.mydiv').on("change",'select[name^="select_services"]',function(event){
            var currentRow=$(this).closest('.subdiv');
            var drop_services= $(this).val();
            $.ajax({
                type : "POST",
                url  : 'ajax_service.php',
                data : {drop_services:drop_services },
                success: function(data){
                    currentRow.find('input[name^="quantity"]').val(1);
                    currentRow.find('input[name^="unit_price"]').val(data);
                    var quantity =currentRow.find('input[name^="quantity"]').val();
                  var unitprice=currentRow.find('input[name^="unit_price"]').val();
                  var total = parseInt(quantity) * parseInt(unitprice);
                  currentRow.find('input[name^="total"]').val(total);
                   //var total=+currentRow.find('input[name^="total"]').val(total);
         // $('#subtotal').val(total);
    var sum = 0;
    $('.total').each(function(){
        if($(this).val()!='')
        {
            sum += parseInt($(this).val());
        }
        
    });
    
var sub = $('#subtotal').val(sum);
var fsub = $('#final_total').val(sum);

var tot_commi = 0;
                }
            });
            
        });
        
</script>
<script>
    function add_number(){
        //discount  
    var subtotal = Number(document.getElementById("subtotal").value);
    if (isNaN(subtotal)) subtotal = 0;  
    var discount = parseFloat(document.getElementById("discount").value);
     if (isNaN(discount)) discount = 0;
    var discount_less = (subtotal) * (discount) / 100 ;
    var result_disc = subtotal - discount_less ;
    var total_exp_amt = document.getElementById("total_disc").value = (result_disc).toFixed(2);
    
     var tax_rate = Number(document.getElementById("tax_rate").value);
    if (isNaN(tax_rate)) tax_rate = 0;  
    var tax_total = (result_disc)* (tax_rate) / 100;
    var total_tax_amt = document.getElementById("total_tax").value = (tax_total).toFixed(2);
     var shipping = Number(document.getElementById("shipping").value);
    if (isNaN(shipping)) shipping = 0;  
    var result_amt = result_disc - tax_total + shipping ;
    var total_amt = document.getElementById("total_amt").value = (result_amt).toFixed(2);
   
    }

</script>
<script>
    const textArea = document.getElementById("remark");
    const maxLength = textArea.getAttribute("maxlength");
    const charCount = document.getElementById("charCount");
    charCount.textContent = `${maxLength} characters remaining`;

    textArea.addEventListener("input", () => {
    const remainingChars = maxLength - textArea.value.length;
    charCount.textContent = `${remainingChars} characters remaining`;
});
</script>

<script>
    $(document).ready(function() {
    // Department Inventory Start

    $('#v_contactnm').on('change', function() {
      var v_contactnm = this.value;
      $.ajax({
        url: "./include/ajax/fetch_po_itemcode.php",
        type: "POST",
        data: {
          v_contactnm : v_contactnm
        },
        cache: false,
        success: function(result) {
          $("#code").html(result);
        }
      });
    });
    $('#code').on('change', function() {
      var code = this.value;
      $.ajax({
        url: "./include/ajax/fetch_po_procuct.php",
        type: "POST",
        data: {
          code : code
        },
        cache: false,
        success: function(result) {
          $("#select_services").html(result);
        }
      });
    });
    $('#select_services').on('change', function() {
      var select_services = this.value;
      $.ajax({
        url: "./include/ajax/fetch_po_price.php",
        type: "POST",
        data: {
          select_services : select_services
        },
        cache: false,
        success: function(result) {
          $("#unit_price").html(result);
        }
      });
    });
     $('#v_contactnm').on('change', function() {
      var v_contactnm = this.value;
      $.ajax({
        url: "./include/ajax/fetch_po_itemcode.php",
        type: "POST",
        data: {
          v_contactnm : v_contactnm
        },
        cache: false,
        success: function(result) {
          $("#codes").html(result);
        }
      });
    });
     $('#codes').on('change', function() {
      var code = this.value;
      $.ajax({
        url: "./include/ajax/fetch_po_procuct.php",
        type: "POST",
        data: {
          code : code
        },
        cache: false,
        success: function(result) {
          $("#select_service").html(result);
        }
      });
    });
    });
</script>
</body>
</html>
<?php
// end protected content
} else {
        echo '<p class="text-center" style="margin-top:350px;" align="center">You are not authorized to access this page redirecting you to the <a href="./index?loginPage=login">login page</a>.';
        echo '<META http-equiv="refresh" content="2;URL=./index?loginPage=login">';
}

?>