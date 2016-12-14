<?php 
	$category = $_GET['category'];
	$operations = ['+', '-'];
	switch($category) {
		case 1:
			firstCategory();
			break;
		case 2:
			secondCategory();
			break;
		case 3:
			thirdCategory();
			break;
		default:
			$response = array(
				'success' => false,
				'message' => 'Unknown category'
			);
			echo json_encode($response);
			break;
	}

	function firstCategory() {
		$expression = getExpression();
		$response['expression'] = $expression['num1'].' '.$expression['operation'].' '.$expression['num2'];
		$response['result'] = $expression['result'] ;

		$response['success'] = true;

		echo json_encode($response);
	}

	function secondCategory() {
		$expression = getExpression();
		$num3 = rand(0, 10);

		$response['leftSide'] = array();
		$response['leftSide']['expression'] = $expression['num1'].' '.$expression['operation'].' '.$expression['num2'];
		$response['leftSide']['result'] = $expression['result'];
		$response['rightSide'] = $num3;

		if($expression['result'] > $num3) {
			$response['result'] = '>';
		}
		else if($expression['result'] < $num3) {
			$response['result'] = '<';
		}
		else {
			$response['result'] = '=';
		}

		$response['success'] = true;
		
		echo json_encode($response);
	}

	function thirdCategory() {
		$expression1 = getExpression();
		$expression2 = getExpression();

		$response['leftSide'] = array();
		$response['leftSide']['expression'] = $expression1['num1'].' '.$expression1['operation'].' '.$expression1['num2'];
		$response['leftSide']['result'] = $expression1['result'];

		$response['rightSide'] = array();
		$response['rightSide']['expression'] = $expression2['num1'].' '.$expression2['operation'].' '.$expression2['num2'];
		$response['rightSide']['result'] = $expression2['result'];

		if($expression1['result'] > $expression2['result']) {
			$response['result'] = '>';
		}
		else if($expression1['result'] < $expression2['result']) {
			$response['result'] = '<';
		}
		else {
			$response['result'] = '=';
		}

		$response['success'] = true;

		echo json_encode($response);
	}

	function getExpression() {
		$randomNumber = rand(0, count($GLOBALS['operations']) - 1);
		$operation = $GLOBALS['operations'][$randomNumber];

		$num1 = rand(0, 9);
		$num2 = rand(0, '-' === $operation ? $num1 : 9 - $num1);
		switch($operation) {
			case '+':
				$result = $num1 + $num2;
				break;
			case '-':
				$result = $num1 - $num2;
				break;
			default:
				$result = 'Error';
				break;
		}

		$data = array(
			'num1' => $num1,
			'num2' => $num2,
			'operation' => $operation,
			'result' => $result
		);

		return $data;
	}
?>