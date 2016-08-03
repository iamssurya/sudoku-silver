<?php
/*
*  1) CHECK THE TABLE IS FULL
*  2) CHECK IF THE VALUE IS PRESENT IN ROW
*  3) CHECK IF THE VALUE IS PRESENT IN COLUMN
*  4) CHECK IF THE VALUE IS PRESENT IN CURRENT 3X3 MATRIX
*   
*/
	$data = (isset($_POST['data']))?$_POST['data']:$_COOKIE['data'];
	if(isset($_POST['data'])){
		setcookie('data',$_POST['data']);
	}
	
	$x=0;$y=0;
	$i=1;
	for($y=0;$y<9;$y++){
		for($x=0;$x<9;$x++){
			if($data[$y][$x] == 0){
				
				$val = recursiveFill($y,$x);
				$data[$y][$x] = $val;
			}
		}
		$i=0;
	}
	
	function recursiveFill($y,$x){
		while($i<=9){
			if(checkRow($y,$i) && checkColumn($x,$i) && checkMatrixGrid($x,$y,$i)){
				print 'pass';
				return $i;
			}else{
				print 'fail';
				$i++;
			}
		}
	}

	function isFull(){
		for($a=0;$a<9;$a++){
			for($b=0;$b<9;$b++){
				if($data[$a][$b] == 0) { return false;}
			}	
		}
		return true;
	}

	function checkRow($y,$i){
		for($a=0;$a<9;$a++){
			if($data[$y][$a] == $i){
				return false;
			}
		}
		return true;
	}
	function checkColumn($x,$i){
		for($a=0;$a<9;$a++){
			if($data[$a][$x] == $i){
				return false;
			}
		}
		return true;
	}
	//
	function checkMatrixGrid($x,$y,$i){
		return true;
	}

	echo json_encode($data);
?>