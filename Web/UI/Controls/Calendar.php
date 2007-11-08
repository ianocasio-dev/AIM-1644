<?php
/**
 * @package Web.UI.Controls
 */
class Calendar extends Panel 
{
	public $MonthYearLabel;
	private $ViewMonth;
	private $ViewYear;
	private $Date;
	private $Month;
	private $Year;
	
	function Calendar($left=0, $top=0, $width=215, $height=200, $timestampTime=null)
	{
		parent::Panel($left, $top, $width, $height);
		//$this->SelectFix = true;
		$this->Border = '1px solid #000000';
		$this->BackColor = '#FFFFCC';
		$daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
		$this->MonthYearLabel = new Label('Out of Service', 0, 0, $width, 25);
		$this->MonthYearLabel->SetCSSClass('NCalHead');
		$leftYear = new Button('<<', 0, 0, 25, 25);
		$leftYear->Click = new ClientEvent("LastYear('$this->Id')");
		$rightYear = new Button('>>', $width-25, 0, 25, 25);
		$rightYear->Click = new ClientEvent("NextYear('$this->Id')");
		$leftMonth = new Button('<', 25, 0, 25, 25);
		$leftMonth->Click = new ClientEvent("LastMonth('$this->Id')");
		$rightMonth = new Button('>', $width-50, 0, 25, 25);
		$rightMonth->Click = new ClientEvent("NextMonth('$this->Id')");
		$this->Controls->AddRange($this->MonthYearLabel, $leftYear, $rightYear, $leftMonth, $rightMonth);
		for($i=6; $i>=0; --$i)
		{
			$this->Controls->Add($lbl = &new Label($daysOfWeek[$i], $i*31, 33, 31));
			$lbl->SetCSSClass('NCalColHead');
		}
		for($i=1; $i<7; ++$i)
			for($j=0; $j<7; ++$j)
			{
				$this->Controls->Add($lbl = &new Label('', $j*31, 33+23*$i, 31));
				$lbl->SetCSSClass('NCalCell');
				$lbl->SetMouseUp(new ClientEvent("CalSelectDate(event,'$this->Id')"));
			}
		$this->SetTimestamp($timestampTime);
	}

	function GetViewMonth()
	{
		return $this->ViewMonth;
	}

	function SetViewMonth($newViewMonth)
	{
		$this->ViewMonth = $newViewMonth;
		$this->UpdateClient();
	}

	function GetViewYear()
	{
		return $this->ViewYear;
	}

	function SetViewYear($newViewYear)
	{
		$this->ViewYear = $newViewYear;
		$this->UpdateClient();
	}

	function GetDate()
	{
		return $this->Date;
	}

	function SetDate($newDate)
	{
		$this->Date = $newDate;
		$this->UpdateClient();
	}

	function GetMonth()
	{
		return $this->Month;
	}

	function SetMonth($newMonth)
	{
		$this->Month = $newMonth;
		$this->UpdateClient();
	}

	function GetYear()
	{
		return $this->Year;
	}

	function SetYear($newYear)
	{
		$this->Year = $newYear;
		$this->UpdateClient();
	}

	function GetTimestamp()
	{
		return mktime(0, 0, 0, $this->Month+1, $this->Date, $this->Year);
	}

	function SetTimestamp($timestampTime)
	{
		if($timestampTime==null)
			$timestampTime = date('U');

		$dateM = date('n', $timestampTime)-1;
		$dateY = date('Y', $timestampTime);
		$this->ViewMonth = $dateM;
		$this->ViewYear = $dateY;
		$this->Date = date('d', $timestampTime);
		$this->Month = $dateM;
		$this->Year = $dateY;
		$this->UpdateClient();
	}

	function GetFullDate()
	{
		$Timestamp = $this->GetTimestamp();
		$date = getdate($Timestamp);
		return $date['weekday'].', '.$date['month'].' '.$date['mday'].', '.$date['year'];
	}

    function SetWidth($width)
    {
        parent::SetWidth($width);
        if($this->MonthYearLabel)
        {
            $this->MonthYearLabel->SetWidth($width);
            $this->Controls->Item[2]->SetLeft($width - 25);
            $this->Controls->Item[4]->SetLeft($width - 50);
        }
    }
                   /*
    function SetHeight($height)
    {
        parent::SetHeight($height);
    }                */

	function UpdateClient()
	{
		//QueueClientFunction($this, "ShowCalendar", "'$this->Id'", $this->ViewMonth, $this->ViewYear, $this->Date, $this->Month, $this->Year);
		QueueClientFunction($this, 'ShowCalendar', array("'$this->Id'", $this->ViewMonth, $this->ViewYear, $this->Date, $this->Month, $this->Year), true, Priority::High);
		/*if($this->HasShown())
			AddScript('ShowCalendar("' . $this->Id . '", ' . $this->ViewMonth . ', ' . $this->ViewYear . ', ' .
				$this->Date . ', ' . $this->Month . ', ' . $this->Year . ');'/*, Priority::High);*/
	}
	
	function Show()
	{
		parent::Show();
		//AddScriptSrc(NOLOHConfig::GetBaseDirectory().NOLOHConfig::GetNOLOHPath()."Javascripts/".(GetBrowser() == "ie"?"IE":"Mozilla")."CalendarScript.js");
		AddNolohScriptSrc('Calendar.js', true);
		$this->UpdateClient();
	}
}

?>