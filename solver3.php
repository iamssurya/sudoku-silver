<?php
	//searchEmptyGrid();
	//fillEmptyGrid(); 
	//    - checkRow()
	//    - checkColumn()
	//	  - checkMatrixGrid()
	//backTrack();
	
	// Initializations
	
	
	class sudoku{
		//public $datum = $_POST['data'];
		public $stack = array();
		//public $data = array();
		public static $data;

		function __construct($d){
			//print 'constructor';
			//print_r($_POST['data']);
			print_r($this);
			sudoku::$data = 3;
			
		}
		public function solveSudoku($raw){
			//global $data;
		//	$this->$data =$raw;
			print_r($this->$data);
			$emptyGrid = $this->searchEmptyGrid();

			if($emptyGrid == 0){
				return json_encode($this->$data);
			}else{
				fillEmptyGrid($emptyGrid,0);
				
			}
		}
		
		
		public function searchEmptyGrid(){
			global $data;
			for($y=0;$y<9;$y++){
				for($x=0;$x<9;$x++){
					if($data[$y][$x] == 0){
						return json_encode(array('x'=>$x,'y'=>$y));
					}
				}
			}
			return 0;
		}

		public function fillEmptyGrid($emptyGrid,$avoid){
			global $data;
			$values = json_decode($emptyGrid);
			$x = $values['x'];
			$y = $values['y'];
			for($i=1;$i<=9;$i++){
				if($i != $avoid){
					if(($this->checkRow($y,$i) == 1) && ($this->checkColumn($x,$i)==1) && ($this->checkMatrixGrid($x,$y,$i)==1)){
						empty($data[$y][$x]);
						$data[$y][$x] = $i;
						array_push($stack,array('x'=>$x,'y'=>$y,'i'=>$i));
					}
					if($i == 9){
						backTrack();
					}
				}
			}
			if($this->searchEmptyGrid() == 0){
				echo json_encode($data);
			}else{
				$this->solveSudoku($data);
				//goto x;
			}
		}
		public function backTrack(){
			global $data,$stack;

			$y_val = $stack[count($stack) - 1]['y'];
			$x_val = $stack[count($stack) - 1]['x'];
			$i_val = $stack[count($stack) - 1]['i'];
			array_pop($stack);
			$this->fillEmptyGrid(json.encode(array('x'=>$x_val,'y'=>y_val)),$i_val);

		}
		public function checkRow($ya,$in){
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
		public function checkColumn($x,$in){
			global $data;
			for($a=0;$a<9;$a++){
				if($data[$a][$x] == $in){
					return 0;
				}
			}
			return 1;
		}
		
		public function checkMatrixGrid($x,$y,$in){
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
	}
	
	$class = new sudoku($_POST['data']);
	$data = $class->solveSudoku($_POST['data']);
	return $data;
?>