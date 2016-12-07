<!-- the file that processes the customer's order ... the form itself utiliizes several different ajax calls to determine the correct item in the database, the script then finds that item with the correct options added on and the customer's discount applied to the item itself --> 

if(isset($_POST['p_order'])) {

	$material = $_POST['mat'];
	$ply = $_POST['ply'];
	$size = $_POST['size'];
	$length = $_POST['length'];
	$hole = $_POST['opening'];
	$options = $_POST['opts'];
	$cust_code = $_POST['cust_code'];

	if($material == 1 && $ply == 1) {
		$mat_code = 'RS3';
	} elseif($material == 1 && $ply == 2) {
		$mat_code = 'RS5';
	} elseif($material == 1 && $ply == 3) {
		$mat_code = 'RS6';
	}

	if($ply == 4) {
		$mat_code = 'RK1P';
	} elseif($ply == 5) {
		$mat_code = 'RKDF';
	} elseif($ply == 6) {
		$mat_code = 'RF3';
	} elseif($ply == '6h') {
		$mat_code = 'HRF3';  
	} elseif($ply == 7) {
		$mat_code = 'RF5';
	} elseif($ply == '7h') {
		$mat_code = 'HRF5';
	} elseif($ply == 8) {
		$mat_code = 'RF6';
	} elseif($ply == '8h') {
		$mat_code = 'HRF6';
	} elseif($ply == 9) {
		$mat_code = 'RF8';
	} elseif($ply == 11) {
		$mat_code = 'BRK1P';
	} elseif($ply == 12) {
		$mat_code = 'BRKDF';
	} elseif($ply == 13) {
		$mat_code = 'BRF3';
	} elseif($ply == '13h') {
		$mat_code = 'BHRF3';
	} elseif($ply == 14) {
		$mat_code = 'BRF5';
	} elseif($ply == '14h') {
		$mat_code = 'BHRF5';
	} elseif($ply == 15) {
		$mat_code = 'BRF6';
	} elseif($ply == '15h') {
		$mat_code = 'BHRF6';
	} elseif($ply == 16) {
		$mat_code = 'BRF8';
	} elseif($ply == 18) {
		$mat_code = 'RNS';
	} elseif($ply == 19) {
		$mat_code = 'HRNS';
	} elseif($ply == 20) {
		$mat_code = 'BRNS';
	} elseif($ply == 21) {
		$mat_code = 'BHRNS';
	}

	if($size == 1) {
		$sz_code = '0A';
	} elseif($size == 2) {
		$sz_code = '01';
	} elseif($size == 3) {
		$sz_code = '12';
	} elseif($size == 4) {
		$sz_code = '23';
	} elseif($size == 5) {
		$sz_code = '35';
	} elseif($size == 6 || $size == 14) {
		$sz_code = 'A/B';
	} elseif($size == 7 || $size == 15) {
		$sz_code = 'B/0';
	} elseif($size == 8 || $size == 16) {
		$sz_code = '0/1';
	} elseif($size == 9 || $size == 17) {
		$sz_code = '0/2';
	} elseif($size == 10 || $size == 18) {
		$sz_code = '1/2';
	} elseif($size == 11 || $size == 19) {
		$sz_code = '2/3';
	} elseif($size == 12 || $size == 20) {
		$sz_code = '3/4';
	} elseif($size == 13 || $size == 21) {
		$sz_code = '4/6';
	}

	if($length == '08') {
		$len_code = '08';
	}  elseif($length == '10b' || $length == 10 || $length == '10c') {
		$len_code = '10'; 
	} elseif($length == '12b' || $length == 12 || $length == '12c') {
		$len_code = '12';
	} elseif($length == '16b' || $length == '16c') {
		$len_code = '16';
	} elseif($length == '20b' || $length == '20c') {
		$len_code = '20';
	} elseif($length == '24b' || $length == '24c') {
		$len_code = '24';
	} elseif($length == 28) {
		$len_code = '28';
	} elseif($length == 06 || $length == '06c') {
		$len_code = '06';
	} elseif($length == 14 || $length == '14c' || $length == '14b') {
		$len_code = '14';
	} elseif($length == 18 || $length == '18c') {
		$len_code = '18';
	} elseif($length == 22 || $length == '22c') {
		$len_code = '22';
	} elseif($length == 26 || $length == '26c') {
		$len_code = '26';
	}

	if($hole == 1) {
		$op = 'GO'; 
	} elseif($hole == 2) {
		$op = 'O';
	} else {
		$op = "";
	}

	$g_d = "SELECT * FROM users WHERE c_id = '".$_POST['u_id']."'";
	$r_d = mysqli_query($con, $g_d); 
	$rw_d = mysqli_fetch_array($r_d);

	$discount = $rw_d['c_discount'];

	if($options == 1) {
		$up_c = 0.5; 
		$d_up = $up_c * $discount;
		$t_dis = $up_c - $d_up;
		$up_s = 'S'; 
	} elseif($options == 2) {
		$up_c = 0.0; 
		$up_s = 'C';
	} elseif ($options == '') {
		$up_c = 0.0;
		$up_s = '';
	}

	if($op == 'GO') {
		$op_uc = 0.5;
	} elseif($op == 'O') {
		$op_uc = 0.0;
	} elseif($op == '') {
		$op_uc = 0.0;
	}

	$po_code = $op . $mat_code . "-" . $sz_code . "-" . $len_code;

	$get_code = "SELECT * FROM products WHERE p_code LIKE '%$po_code%'";
	$run_code = mysqli_query($con, $get_code); 
	$row_code = mysqli_fetch_array($run_code);

	$count = $_POST['ord_amt'];

	if($rw_d['c_discount'] != '') {

		$sum_total = (($row_code['p_price'] + $up_c) * $count) * $rw_d['c_discount'];
		
	} else {

		$sum_total = (($row_code['p_price'] + $up_c) * $count);

	}	

	$tot_price = ((($row_code['p_price'] + $up_c) * $count) - $sum_total) + $op_uc;

	$date = date("Y-m-d h:i:s T");

	if($row_code['p_code'] != '') {

	$insert = "INSERT INTO processing_orders (c_id, po_options, po_opening, po_code, po_amnt, po_price, po_date, po_status) VALUES ('".$_POST['c_id']."', '".$up_s."', '".$op."', '".$row_code['p_code']."', '".$_POST['ord_amt']."', '".number_format($tot_price,2)."', '".$date."', 'processing')";

	$run_insert = mysqli_query($con, $insert); 

		echo "<script>window.open('order-info.php?u_id=".$_SESSION['u_id']."', '_self')</script>";

	} else {

		echo "<script>alert('Please Build an Item')</script><script>window.open('order-info.php?u_id=".$_SESSION['u_id']."', '_self')</script>";
	
	}

}
