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
	//echo $data[0][0];
	$stack = array();
	$x=0;$y=0;
	$i=1;
	$currentX =0;
	$currentY = 0;
	$currentI = 1;
	function isFull(){
		global $data;
		for($a=0;$a<9;$a++){
			for($b=0;$b<9;$b++){
				if($data[$a][$b] == 0) { return 0;}
			}	
		}
		return 1;
	}

	fillGrid($currentX,$currentY,$currentI);

	function fillGrid($currentX,$currentY,$currentI){
		global $data,$currentI,$stack;
		for($y=$currentY;$y<9;$y++){
			for($x=$currentX;$x<9;$x++){
				if($data[$y][$x] == 0){
					$resp = recursiveFill($y,$x,$currentI);

				}
			}
		}
		if(isFull() == 0){
			//fillGrid();
			//print 'isnotfull';
		}
	}
	
	
	
	function recursiveFill($y,$x,$index){
		global $data,$currentI,$stack;
		//$index = 1;
		while($index < 10){
			if((checkRow($y,$index) == 1) && (checkColumn($x,$index) == 1) && (checkMatrixGrid($x,$y,$index) == 1)){
				$data[$y][$x] = $index;
				array_push($stack, array('y'=>$y,'x'=>$x,'i'=>$index));
				return 1;
				
			}else{
				$index++;
			}
		}

		
		popLatest();
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
		//echo "xaxis ".$x_axis+30." and yaxis $y_axis";
		for($a=$y_axis;$a<$y_max;$a++){
			for($b=$x_axis;$b<$x_max;$b++){
				//echo 'comparing ($a,$b) : $data[$a][$b] with $in';
				if($data[$a][$b] == $in){
					return 0;
				}
			}
		}
		return 1;
	}

	function popLatest(){
		global $data,$stack,$currentX,$currentY,$currentI;
		//echo $stack[count($stack)-1]['x'];
		
		$currentX = $stack[count($stack)-1]['x'];
		$currentY = $stack[count($stack)-1]['y'];
		$currentI = $stack[count($stack)-1]['i'] + 1;

		array_pop($stack);
		fillGrid($currentY, $currentX, $currentI);

	}
	echo json_encode($data);
?>