<?php
	
	$data = (isset($_POST['data']))?$_POST['data']:array(array('0','1'),array('2','4'));
	$x=0;$y=0;
	$i=1;
	for($y=0;$y<9;$y++){
		for($x=0,$i=1;$x<9;$x++,$i++){
			if($data[$y][$x] == 0){
				$data[$y][$x] = $i;
			}
		}
		$i=0;
	}
	
	function isFull(){
		for($a=0;$a<9;$a++){
			for($b=0;$b<9;$b++){
				if($data[$a][$b] == 0) { return false;}
			}	
		}
		return true;
	}

	echo json_encode($data);
?>