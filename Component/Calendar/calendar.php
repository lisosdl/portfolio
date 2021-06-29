<?php

namespace Component\Calendar;

class Calendar 
{
	/**
	* 달력 일수 
	*
	* @param String $year
	* @param String $month
	*
	* @return Array
	*/
	public function get($year = null, $month = null)
	{
		$year = $year?$year:date("Y");
		$month = $month?$month:date("m");
		$month = (strlen($month) == 1)?"0".$month:$month;
		
		// 시작일 timestamp
		$startStamp = strtotime($year.$month."01");
		
		$yoil = date('w', $startStamp);
		
		$startNo = $yoil * -1;
		$endNo = 42 + $startNo;
		
		$days = []; // 달력 날짜 
		$nextMonthDays = 0;
		for ($i = $startNo; $i < $endNo; $i++) {
			$newStamp = $startStamp + (60 * 60 * 24 * $i);
			if ($newStamp > $startStamp && date("m", $newStamp) != date("m", $startStamp)) {
				$nextMonthDays++;
			}
			
			$days[] = [
				'stamp' => $newStamp,
				'yoil' => $this->getYoil($newStamp),
				'date' => date("Y.m.d", $newStamp),
				'day' => date("d", $newStamp),
			];
		} // endfor 
		
		/** 다음달이 7일 이상인 경우는 1주 제외(35) */
		if ($nextMonthDays >= 7) {
			$days = array_chunk($days, 35);
			$days = $days[0];
		}

		/** 전달, 다음달 */
		$month = (Integer)$month;
		$prevYear = $nextYear = $year;
		$prevMonth = $nextMonth = $month;
		
		if ($month == 1) {
			$prevYear--;
			$prevMonth = 12;
			$nextMonth++;
		} else if ($month == 12) {
			$nextYear++;
			$nextMonth = 1;
			$prevMonth--;
		} else {
			$prevMonth--;
			$nextMonth++;
		}
		
		$prevMonth = (strlen($prevMonth) == 1)?"0".$prevMonth:$prevMonth;
		$nextMonth = (strlen($nextMonth) == 1)?"0".$nextMonth:$nextMonth;
		
		return [
			'days' => $days,
			'prevYear' => $prevYear, 
			'prevMonth' => $prevMonth,
			'nextYear' => $nextYear,
			'nextMonth' => $nextMonth,
		];
	}
	
	/** 
	* 요일목록
	*
	*/
	public function getYoils()
	{
		return ["일","월","화","수","목","금","토"];
	}
	
	/**
	* timestamp에 따른 요일 
	*
	*/
	public function getYoil($stamp)
	{
		$yoils = $this->getYoils();
		$yoil = date("w", $stamp);
		
		return $yoils[$yoil];
	}
}
