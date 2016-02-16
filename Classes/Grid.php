<?php
namespace Classes;
include "Classes/Validation.php";
session_start();
class Grid
{
	protected $_row;
	protected $_col;
	protected $_shots;
	protected $_grid;
	protected $_gridFin;
	protected $_message;
	public function __construct()
	{
		$this->_row = 10;
		$this->_col = 10;
		$this->_shots = 0;
		$this->_grid = array();
		$this->_gridFin = "false";
		$this->_message = " ";
	}
	private function EmptyGrid()
	{
		for($i=0;$i<$this->_row;$i++)
		{
			for($j=0;$j<$this->_col;$j++)
			{
				$this->_grid[$i][$j] = " ";
			}
		}
	}
	private function ImportPositionShip(Ship $ship)
	{
		$pos = 	$ship->PositionInitial();
		$long = $ship->GetLong();
		$posL = $ship->GetPositionLetter();
		$posN = $ship->GetPositionNumber();
		$orientation = $ship->GetOrientation();
		
		$distanceShipL = (($posL) - 65);
		$distanceShipN = $this->_col - $posN;
		if($orientation == 1)//North
		{
			if($long > ($this->_col - $distanceShipL)){//Grow to north
				//Check if some box are occupied by other ship
				$i=0;
				$isEmpty='true';
				while(($i<$long)&&($isEmpty=='true')){
					if($this->_grid[$distanceShipL][$distanceShipN]=='X'){
						$isEmpty='false';
					}
					$distanceShipL--;
					$i++;
				}
				$distanceShipL = $distanceShipL + $long;
				if($isEmpty=='true'){
					for($j=0;$j<$long;$j++){
						$this->_grid[$distanceShipL][$distanceShipN]='X';
						$ship->SetPosition($distanceShipL, $distanceShipN);
						//print_r($this->_grid[$distanceShipL][$distanceShipN]. " fila-> ". $distanceShipL . " col-> ".$distanceShipN );
						$distanceShipL--;
					}
					$distanceShipL = $distanceShipL + $long;
					$ship->SetShipSet('true');
				}
			}
		}
		else if($orientacion == 2)//West
		{
				if($long > ($this->_row - $distanceShipN)){//Grow to West
					//Check if some box are occupied by other ship
					$i=0;
					$isEmpty='true';
					while(($i<$long)&&($isEmpty=='true')){
						if($this->_grid[$distanceShipL][$distanceShipN]=='X'){
							$isEmpty='false';
						}
						$distanceShipN--;
						$i++;
					}
					$distanceShipN = $distanceShipN + $long;
					if($isEmpty=='true'){
						for($j=0;$j<$long;$j++){
							$this->_grid[$distanceShipL][$distanceShipN]='X';
							$ship->SetPosition($distanceShipL, $distanceShipN);
							//print_r($this->_grid[$distanceShipL][$distanceShipN]. " fila-> ". $distanceShipL . " col-> ".$distanceShipN );
							$distanceShipN--;
						}
						$distanceShipN = $distanceShipN + $long;
						$ship->SetShipSet('true');
					}
				}
			}
			else if($orientacion == 3)//South
			{
				if($long > ($this->_col - $distanceShipL)){//Grow to north
					//Check if some box are occupied by other ship
					$i=0;
					$isEmpty='true';
					while(($i<$long)&&($isEmpty=='true')){
						if($this->_grid[$distanceShipL][$distanceShipN]=='X'){
							$isEmpty='false';
						}
						$distanceShipL++;
						$i++;
					}
					$distanceShipL = $distanceShipL - $long;
					if($isEmpty=='true'){
						for($j=0;$j<$long;$j++){
							$this->_grid[$distanceShipL][$distanceShipN]='X';
							$ship->SetPosition($distanceShipL, $distanceShipN);
							//print_r($this->_grid[$distanceShipL][$distanceShipN]. " fila-> ". $distanceShipL . " col-> ".$distanceShipN );
							$distanceShipL++;
						}
						$distanceShipL = $distanceShipL - $long;
						$ship->SetShipSet('true');
					}
				}
			}else if ($orientation == 4){//East
					if($long < ($this->_col - $distanceShipN)){//Grow to East
						//Check if some box are occupied by other ship
						$i=0;
						$isEmpty='true';
						while(($i<$long)&&($isEmpty=='true')){
							if($this->_grid[$distanceShipL][$distanceShipN]=='X'){
								$isEmpty='false';
							}
							$distanceShipN++;
							$i++;
						}
						$distanceShipN = $distanceShipN - $long;
						if($isEmpty=='true'){
							for($j=0;$j<$long;$j++){
								$this->_grid[$distanceShipL][$distanceShipN]='X';
								$ship->SetPosition($distanceShipL, $distanceShipN);
								//print_r($this->_grid[$distanceShipL][$distanceShipN]. " fila-> ". $distanceShipL . " col-> ".$distanceShipN );
								$distanceShipN++;
							}
							$distanceShipN = $distanceShipN - $long;
							$ship->SetShipSet('true');
						}
					}
				}
	}
	public function InitializeGrid(Battleship $battleship,Destroyers $destroyer1,Destroyers $destroyer2)
	{
		$battleship->SetShipSet("false");
		$destroyer1->SetShipSet("false");
		$destroyer2->SetShipSet("false");
		
		
		while(	($battleship->GetShipSet() == 'false') ||
				($destroyer1->GetShipSet() == 'false') ||
				($destroyer2->GetShipSet() == 'false')
			 )
		{
			if($battleship->GetShipSet() == 'false')
			{
				$battleship->InitializePositions();
				$this->ImportPositionShip($battleship);
			}
				
			if($destroyer1->GetShipSet() == 'false')
			{
				$destroyer1->InitializePositions();
				$this->ImportPositionShip($destroyer1);
			}
				
			if($destroyer2->GetShipSet() == 'false')
			{
				$destroyer2->InitializePositions();
				$this->ImportPositionShip($destroyer2);
			}
				
		}
	}
	
	public function DisplayGrid(Battleship $battleship,Destroyers $destroyer1,Destroyers $destroyer2,$value=NULL)
	{		
		$l = substr($value,0,1);
		$n = substr($value,1,1);
		$l = ord($l)-65;
		
		$arrayBattleship = $battleship->GetPositions();
		$arrayDest1 = $destroyer1->GetPositions();
		$arrayDest2 = $destroyer2->GetPositions();
		echo "<table>
				<tr>";
		for($h=0;$h<=$this->_col;$h++)
		{
			if(($h==($this->_col))){
				echo "<th>0</th>";
			}else if($h == 0){
				echo "<th></th><th></th>";
			}
			else{
				echo "<th>".$h."</th>";
			}
		}
		echo "</tr>";
		$letter = 65;
		for($r=0;$r<$this->_row;$r++)
		{
			echo "<tr>";
			for($c=0;$c<=$this->_col;$c++){
				$valueTmp = chr($letter).$c;
				if($c==0){
					echo "<th>".chr($letter)."</th><td></td>";
				}else{
					if(($arrayBattleship[$valueTmp] == 'true')||
					($arrayDest1[$valueTmp] == 'true')||
					($arrayDest2[$valueTmp] == 'true')){
						echo "<td><strong>X</strong></td>";
					}
					else if($this->_grid[$r][$c] == "-"){
						echo "<td><strong>-</strong></td>";
					}else{
						echo "<td><strong>.</strong></td>";
					}	
				}
				
			}
			echo "</tr>";
			$letter++;
		}
		echo "</table>";
	}
	public function ShowGrid(Battleship $battleship,Destroyers $destroyer1,Destroyers $destroyer2)
	{
		$arrayBattleship = $battleship->GetPositions();
		$arrayDest1 = $destroyer1->GetPositions();
		$arrayDest2 = $destroyer2->GetPositions();
		$_SESSION["message"] = " ";
		echo "<table>
				<tr>";
		for($h=0;$h<=$this->_col;$h++)
		{
			if(($h==($this->_col))){
				echo "<th>0</th>";
			}else if($h == 0){
				echo "<th></th><th></th>";
			}
			else{
				echo "<th>".$h."</th>";
			}
		}
		echo "</tr>";
		$letter = 65;
		for($r=0;$r<=$this->_row;$r++)
		{
			echo "<tr>";
			for($c=0;$c<=$this->_col;$c++){
				$valueTmp = chr($letter).$c;
				if($c==0){
					echo "<th>".chr($letter)."</th><td></td>";
				}else{
					if(($this->_grid[$r][$c] == 'X')&&(($arrayBattleship[$valueTmp] == 'true')||
														($arrayDest1[$valueTmp] == 'true')||
														($arrayDest2[$valueTmp] == 'true'))){
						echo "<td><strong></strong></td>";
					}else if(($this->_grid[$r][$c] == 'X')&&(($arrayBattleship[$valueTmp] == 'false')||
														($arrayDest1[$valueTmp] == 'false')||
														($arrayDest2[$valueTmp] == 'false'))){
						echo "<td><strong>X</strong></td>";
					}else 
						echo "<td><strong></strong></td>";
				}
		
			}
			echo "</tr>";
			$letter++;
		}
		echo "</table>";
	}
	private function ShotInsideGrid($value)
	{
		$letter = substr($value,0,1);
		$number = substr($value,1,1);
		$letter = ord($letter)-65;
		$result = 'false';
		if($letter <= $this->_row && $number <= $this->_col){
			$result = 'true';
		}
		return $result;
	}
	public function Shot(Battleship $battleship,Destroyers $destroyer1,Destroyers $destroyer2, $value )
	{
		$value = strtoupper($value);
		$letter = ord(substr($value,0,1))-65;
		$number = substr($value,1,1);
		$_SESSION["message"] = " ";
		$this->_message = " ";
		$validate = new Validation();
		if($validate->ValidateField($value, $this->_grid)){
			$arrayBattleship = $battleship->GetPositions();
			$arrayDest1 = $destroyer1->GetPositions();
			$arrayDest2 = $destroyer2->GetPositions();
			$existPositions = 'true';
			if($this->ShotInsideGrid($value)){
				if(array_key_exists($value,$arrayBattleship)&&($arrayBattleship[$value] == 'false')){
					$battleship->hit($value);
					$_SESSION["message"] = "*** Hit ***";
					$this->_message = "*** Hit ***";
					if($battleship->GetHits() == 0){
						$this->_message = "*** Sunk ***";
						$battleship->SetSink("true");
					}
				}else if(array_key_exists($value,$arrayDest1)&&($arrayDest1[$value] == 'false')){
					$destroyer1->hit($value);
					$_SESSION["message"] = "*** Hit ***";
					$this->_message = "*** Hit ***";
					if($destroyer1->GetHits() == 0){
						$this->_message = "*** Sunk ***";
						$destroyer1->SetSink("true");
					}
				}else if(array_key_exists($value,$arrayDest2)&&($arrayDest2[$value] == 'false')){
					$destroyer2->hit($value);
					$_SESSION["message"] = "*** Hit ***";
					$this->_message = "*** Hit ***";
					if($destroyer2->GetHits() == 0){
						$this->_message = "*** Sunk ***";
						$destroyer2->SetSink("true");
					}
				}else if(!array_key_exists($value,$arrayBattleship)&&
						(!array_key_exists($value,$arrayDest1))&&
						(!array_key_exists($value,$arrayDest2))){
							$this->_grid[$letter][$number] = "-";
							$_SESSION["message"] = "*** Miss ***";
							$this->_message = "*** Miss ***";
				}
			}else{
				$_SESSION["message"] = "*** Error ***";
				$this->_message = "*** Error ***";
			}
			$this->_shots++;
		}else{
			$_SESSION["message"] = "*** Error ***";
			$this->_message = "*** Error ***";
		}
		$_SESSION["battleship"] = serialize($battleship);
		$_SESSION["destroyer1"] = serialize($destroyer1);
		$_SESSION["destroyer2"] = serialize($destroyer2);
		$_SESSION["message"] = " ";
		if($battleship->IsSink()=="true" && $destroyer1->IsSink()=="true" && $destroyer2->IsSink()=="true"){
			$this->_gridFin = "true";
		}
	}
	public function GetShots()
	{
		return $this->_shots;
	}
	public function GetRows()
	{
		return $this->_row;
	}
	public function GetCols()
	{
		return $this->_col;
	}
	public function GetMessage()
	{
		return $this->_message;
	}
	public function SetMessage($value)
	{
		return $this->_message=$value;
	}
	public function GetGridFin()
	{
		return $this->_gridFin;
	}
}