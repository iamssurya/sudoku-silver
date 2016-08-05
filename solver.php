<?php
/*
*  1) CHECK THE TABLE IS FULL
*  2) CHECK IF THE VALUE IS PRESENT IN ROW
*  3) CHECK IF THE VALUE IS PRESENT IN COLUMN
*  4) CHECK IF THE VALUE IS PRESENT IN CURRENT 3X3 MATRIX
*   
*/
/*
	if(isset($_POST['data'])){
		setcookie('data',$_POST['data']);
	}*/
	//ini_set('memory_limit', '4000M');
	ini_set ('max_execution_time', 0);
	$data = (isset($_POST['data']))?$_POST['data']:$_COOKIE['data'];
	
	$currentX = 0;$currentY = 0;$ignoreN;
	$stack = array();
	// Staring the algorithm

	//findEmptyGrid($currentX,$currentY,0);

	// Check if the sudoku is solved
	function sudokuSolved(){
		global $data;
		for($y=0;$y<9;$y++){
			for($x=0;$x<9;$x++){
				if($data[$y][$x] == 0){
					return 0;
				}
			}
		}
		return 1;
	}
	function findEmptyGrid($currentY,$currentX,$i_n){
		global $data,$stack;
		for($y=$currentY;$y<9;$y++){
			for($x=$currentX;$x<9;$x++){
				if($data[$y][$x] == 0){
					//print "Checking ($y,$x)";
					$ans = fillGrid($y,$x,$i_n);
					//print "ans : $ans";
				}
			}
		}
	}
	function fillGrid($y,$x,$i_n){
		global $data,$stack;
		for($i=1;$i<10;$i++){
			if($i != $i_n){
				if((checkRow($y,$i) == 1) && (checkColumn($x,$i)==1) && (checkMatrixGrid($x,$y,$i)==1)){
					empty($data[$y][$x]);
					$data[$y][$x] = $i;
					
					array_push($stack,array('x'=>$x,'y'=>$y,'i'=>$i));
					return 1;
				}
			}
			if($i == 9){
				// Backtracks
				//return -1;
				//findEmptyGrid($stack[count($stack) - 1]['x'],$stack[count($stack) - 1]['y'],$stack[count($stack)-1]['i']);
				//findEmptyGrid(0,0,0);
				$y_val = $stack[count($stack) - 1]['y'];
				$x_val = $stack[count($stack) - 1]['x'];
				$i_val = $stack[count($stack) - 1]['i'];
				array_pop($stack);
				$result = fixGrid($y_val,$x_val,$i_val);
				return $result;
				

				
			}
		}
	}
	function fixGrid($y,$x,$i){
		global $data;
		for($a=1;$a<=9;$a++){
			if($a != $i){
				if((checkRow($y,$i) == 1) && (checkColumn($x,$i)==1) && (checkMatrixGrid($x,$y,$i)==1)){
					empty($data[$y][$x]);
					$data[$y][$x] = $i;
					
					array_push($stack,array('x'=>$x,'y'=>$y,'i'=>$i));
					return 1;
				}
			}
			if($a==9){
				$y_val = $stack[count($stack) - 1]['y'];
				$x_val = $stack[count($stack) - 1]['x'];
				$i_val = $stack[count($stack) - 1]['i'];
				array_pop($stack);
				$result = fixGrid($y_val,$x_val,$i_val);
				if($result == 1){
					return 1;
				}
			}
		}
	}
	function checkRow($ya,$in){
		global $data;
		$ya = $ya;
		$in = $in;
		
		for($a=0;$a<9;$a++){
			if($data[$ya][$a] == $in){
				return 0;
			}
		}
		return 1;
	}
	function checkColumn($x,$in){
		global $data;
		for($a=0;$a<9;$a++){
			if($data[$a][$x] == $in){
				return 0;
			}
		}
		return 1;
	}
	
	function checkMatrixGrid($x,$y,$in){
		global $data;
		
		if($x >=0 && $x <=2){
			$x_axis = 0; 
			$x_max = 3;
		}
		else if($x >=3 && $x<=5){
			$x_axis = 3;
			$x_max = 6;
		}else{ $x_axis = 6; $x_max = 9;}

		if($y >=0 && $y <=2){
			$y_axis = 0; 
			$y_max = 3;
		}
		else if($y >=3 && $y<=5){
			$y_axis = 3;
			$y_max = 6;
		}else{ $y_axis = 6; $y_max = 9;}
		
		for($a=$y_axis;$a<$y_max;$a++){
			for($b=$x_axis;$b<$x_max;$b++){
				if($data[$a][$b] == $in){
					return 0;
				}
			}
		}
		return 1;
	}
	
	findEmptyGrid(0,0,0);
	
	
	
	
	
	echo json_encode($data);
?>