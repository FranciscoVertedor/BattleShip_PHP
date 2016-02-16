<?php
namespace Classes;
require_once 'Ship.php';

class Battleship extends Ship
{
	public function __construct()
	{
		$this->_long = 5;
		$this->_sink = "false";
		$this->_hits = $this->_long;
	}
	public function SetPosition($letter,$number)
	{
		$letter = $letter + 65;
		$letter = chr($letter);
		$index = $letter.$number;
		$this->_positions[$index] = 'false';
	}
	public function GetPositions()
	{
		return $this->_positions;
	}
	public function hit($index = NULL)
	{
		if($this->_hits > 0){
			$this->_positions[$index] = "true";
			$this->_hits--;
		}
	}
}