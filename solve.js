// Global variables
global.$stack = [];
global.i = 0;
global.finishSudoku = function(){
	
	
	console.log("finishing sudoku");
	
	$('table').find('tr').each(function(rowIndex,r){
			$(this).find('th,td').each(function (colIndex, c) {
				c.children[0].value = global.data[rowIndex][colIndex];
				console.log('filling '+rowIndex+','+colIndex+' :'+global.data[rowIndex][colIndex]);
        });
	});
	
	
}
global.solveSudoku = function(){
	var $emptyGrid = global.searchEmptyGrid();
	if(typeof $emptyGrid ==='number' && $emptyGrid == 0){
		global.finishSudoku(global.data);
	}else if(typeof $emptyGrid === 'object'){
		global.fillEmptyGrid($emptyGrid,0);
	}
}

global.searchEmptyGrid = function(){
	console.log('searching for empty grid');
	var $x,$y;
	for($y=0;$y<9;$y++){
		for($x=0;$x<9;$x++){
			if(global.data[$y][$x] == 0){
				console.log('Found empty grid :'+$y+','+$x);
				return {
					x: $x,
					y: $y
				};
			}
		}
	}
	return 0;
}

global.fillEmptyGrid = function(grid,avoid){
	var $avoid = avoid;
	var $x = grid.x,$y = grid.y;
	var $i;
	for($i=1;$i<=9;$i++){
		if($i != $avoid){
			if((global.checkRow($y,$i) == 1) && (global.checkColumn($x,$i)==1) && (global.checkMatrixGrid($x,$y,$i)==1)){
				global.data[$y][$x] = $i;
				console.log('Pushed to ('+$y+','+$x+') : '+$i);
				global.$stack.push({
					'x':$x,
					'y':$y,
					'i':$i
				});
				global.solveSudoku();
			}
		}else{
			console.log("Avoided :"+$avoid+" for ("+$y+","+$x+")");
		}
		
	}
	if($i > 9){
		console.log('need for backtracking ');
		global.backTrack();
		//break;
		
	}
	//global.solveSudoku();
	console.log('executing the end of fillEmptyGrid');

}
global.backTrack = function(){
	var $y = global.$stack[global.$stack.length-1]['y'];
	var $x = global.$stack[global.$stack.length-1]['x'];
	var $i = global.$stack[global.$stack.length-1]['i'];

	global.data[$y][$x] = 0;
	console.log("Setting to zero ("+$y+','+$x+') and value :'+global.data[$y][$x]);
	var obj = {
		x: $x,
		y: $y
	}
	global.$stack.pop();
	global.fillEmptyGrid(obj,parseInt($i));
}

// Supportive functions

global.checkRow = function($ya,$in){
	
	var $ya = $ya;
	var $in = $in;
	
	for(var $a=0;$a<9;$a++){
		if(global.data[$ya][$a] == $in){
			return 0;
		}
	}
	return 1;
}
global.checkColumn = function($x,$in){
	for(var $a=0;$a<9;$a++){
		if(global.data[$a][$x] == $in){
			return 0;
		}
	}
	return 1;
}

global.checkMatrixGrid = function($x,$y,$in){

	var $x_axis,$x_max,$y_axis,$y_max;
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
	
	for(var $a=$y_axis;$a<$y_max;$a++){
		for(var $b=$x_axis;$b<$x_max;$b++){
			if(global.data[$a][$b] == $in){
				return 0;
			}
		}
	}
	return 1;
}
