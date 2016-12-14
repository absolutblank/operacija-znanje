<?php 
	$giveCandy = $_POST['giveCandy'];
	if($giveCandy) {
		exec('../giveCandy');
		$response['success'] = true;
		echo json_encode($response);
		return;
	}
	$response['success'] = false;
	$response['message'] = 'Candy is not given';
	echo json_encode($response);
?>