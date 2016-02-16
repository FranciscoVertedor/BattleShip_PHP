<?php
namespace Classes;
include_once 'Classes/Grid.php';
class Validation
{
	public function ValidateField($value){
		$letter = strtoupper(substr($value,0,1));
		$number = substr($value,1,1);
		$letter = ord($letter);
		$result = false;
		if($letter >= 65 && $letter <= 65+10){
			if((is_numeric($number)) && ($number >= 0 && $number <= 9)){
				$result = true;
			}
		}
		return $result;
	}
}