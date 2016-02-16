<?php

namespace Classes;

abstract class Ship
{
	//Properties defined here
	protected $_long;
	protected $_position_letter;
	protected $_position_number;
	protected $_orientation;
	protected $_shipSet;
	protected $_positions;
	protected $_sink;
	protected $_hits;
	//methods defined here
	public function GetLong()
	{
		return $this->_long;
	}
	public function PositionInitial()
	{
		$this->_position_letter = rand(65,74);
		$this->_position_number = rand(0,9);
		$this->_orientation = rand(1,4);//Return value 1 to 4 , 1-North, 2-West, 3-South, 4-East
		
	}
	public function GetPositionLetter()
	{
		return $this->_position_letter;
	}
	public function GetPositionNumber()
	{
		return $this->_position_number;
	}
	public function GetOrientation()
	{
		return $this->_orientation;
	}
	public function SetShipSet($isSet)
	{
		$this->_shipSet = $isSet;
	}
	public function GetShipSet()
	{
		return $this->_shipSet;
	}
	public function IsSink()
	{
		return $this->_sink;
	}
	public function SetSink($value)
	{
		$this->_sink = $value;
	}
	public function InitializePositions()
	{
		$this->_positions = array();
	}
	public function GetHits()
	{
		return $this->_hits;
	}
	
}