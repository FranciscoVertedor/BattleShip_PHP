<?php

include "Classes/Battleship.php";
include "Classes/Destroyers.php";
include "Classes/Grid.php";

if(!isset($_POST["send"])){
		$battleship = new \Classes\Battleship();
		$destroyer1 = new \Classes\Destroyers();
		$destroyer2 = new \Classes\Destroyers();
		$grid = new \Classes\Grid();
		$grid->InitializeGrid($battleship,$destroyer1,$destroyer2);
		$_SESSION["battleship"] = serialize($battleship);
		$_SESSION["destroyer1"] = serialize($destroyer1);
		$_SESSION["destroyer2"] = serialize($destroyer2);
		$_SESSION["grid"] = serialize($grid);
		$grid->DisplayGrid($battleship,$destroyer1,$destroyer2);
		?>
				<form action="" method="POST" name="form_coor">
				<label>Enter coordinates (row, col), e.g. A5</label>
				<input type="text" name="coor" maxlength="4" />
				<input type="submit" name="send" value="Send"/>
				</form>
				<?php 
}else{
	$battleship=unserialize($_SESSION["battleship"]);
	$destroyer1=unserialize($_SESSION["destroyer1"]);
	$destroyer2=unserialize($_SESSION["destroyer2"]);
	$grid = unserialize($_SESSION["grid"]);
		if(isset($_POST["coor"]) &&(($_POST["coor"] == "SHOW" )||(($_POST["coor"] == "show" )))){
			$grid = unserialize($_SESSION["grid"]);
			$grid->ShowGrid($battleship,$destroyer1,$destroyer2);
		}else if(isset($_POST["coor"]) && ($_POST["coor"] != "" )){
			$grid = unserialize($_SESSION["grid"]);
			$grid->Shot($battleship, $destroyer1, $destroyer2, $_POST["coor"]);
			if($grid->GetGridFin() == "true"){
				echo "Well done! You completed the game in ". $grid->GetShots() . " shots";
			}else{
				echo $grid->GetMessage();
				$grid->DisplayGrid($battleship, $destroyer1, $destroyer2,$_POST["coor"]);
			}
		}else{
			$grid = unserialize($_SESSION["grid"]);
			$grid->DisplayGrid($battleship, $destroyer1, $destroyer2,$_POST["coor"]);
		}
		
		$_SESSION["grid"] = serialize($grid);
		if($grid->GetGridFin() != "true"){
			?>
			<form action="" method="POST" name="form_coor">
			<label>Enter coordinates (row, col), e.g. A5</label>
			<input type="text" name="coor" maxlength="4" />
			<input type="submit" name="send" value="Send"/>
			</form>
			<?php 
		}
}

?>

