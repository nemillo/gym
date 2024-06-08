<?php

//CALENDARIO WEB 


// PHP Calendar Class Version 1.4 (5th March 2001)
//  
// Copyright David Wilkinson 2000 - 2001. All Rights reserved.
// 
// This software may be used, modified and distributed freely
// providing this copyright notice remains intact at the head 
// of the file.
//
// This software is freeware. The author accepts no liability for
// any loss or damages whatsoever incurred directly or indirectly 
// from the use of this script. The author of this software makes 
// no claims as to its fitness for any purpose whatsoever. If you 
// wish to use this software you should first satisfy yourself that 
// it meets your requirements.
//
// URL:   http://www.cascade.org.uk/software/php/calendar/
// Email: davidw@cascade.org.uk


class Calendar
{
    /*
        Constructor for the Calendar class
    */
    function Calendar()
    {
    }
    
    
    /*
        Get the array of strings used to label the days of the week. This array contains seven 
        elements, one for each day of the week. The first entry in this array represents Sunday. 
    */
    function getDayNames()
    {
        return $this->dayNames;
    }
    

    /*
        Set the array of strings used to label the days of the week. This array must contain seven 
        elements, one for each day of the week. The first entry in this array represents Sunday. 
    */
    function setDayNames($names)
    {
        $this->dayNames = $names;
    }
    
    /*
        Get the array of strings used to label the months of the year. This array contains twelve 
        elements, one for each month of the year. The first entry in this array represents January. 
    */
    function getMonthNames()
    {
        return $this->monthNames;
    }
    
    /*
        Set the array of strings used to label the months of the year. This array must contain twelve 
        elements, one for each month of the year. The first entry in this array represents January. 
    */
    function setMonthNames($names)
    {
        $this->monthNames = $names;
    }
    
    
    
    /* 
        Gets the start day of the week. This is the day that appears in the first column
        of the calendar. Sunday = 0.
    */
      function getStartDay()
    {
        return $this->startDay;
    }
    
    /* 
        Sets the start day of the week. This is the day that appears in the first column
        of the calendar. Sunday = 0.
    */
    function setStartDay($day)
    {
        $this->startDay = $day;
    }
    
    
    /* 
        Gets the start month of the year. This is the month that appears first in the year
        view. January = 1.
    */
    function getStartMonth()
    {
        return $this->startMonth;
    }
    
    /* 
        Sets the start month of the year. This is the month that appears first in the year
        view. January = 1.
    */
    function setStartMonth($month)
    {
        $this->startMonth = $month;
    }
    
    
    /*
        Return the URL to link to in order to display a calendar for a given month/year.
        You must override this method if you want to activate the "forward" and "back" 
        feature of the calendar.
        
        Note: If you return an empty string from this function, no navigation link will
        be displayed. This is the default behaviour.
        
        If the calendar is being displayed in "year" view, $month will be set to zero.
    */
    function getCalendarLink($month, $year)
    {
        return "";
    }
    
    /*
        Return the URL to link to  for a given date.
        You must override this method if you want to activate the date linking
        feature of the calendar.
        
        Note: If you return an empty string from this function, no navigation link will
        be displayed. This is the default behaviour.
    */
    function getDateLink($day, $month, $year)
    {
        return "";
    }


    /*
        Return the HTML for the current month
    */
    function getCurrentMonthView()
    {
        $d = getdate(time());
        return $this->getMonthView($d["mon"], $d["year"]);
    }
    

    /*
        Return the HTML for the current year
    */
    function getCurrentYearView()
    {
        $d = getdate(time());
        return $this->getYearView($d["year"]);
    }
    
    
    /*
        Return the HTML for a specified month
    */
    function getMonthView($month, $year)
    {
        return $this->getMonthHTML($month, $year);
    }
    

    /*
        Return the HTML for a specified year
    */
    function getYearView($year)
    {
        return $this->getYearHTML($year);
    }
    
    
    
    /********************************************************************************
    
        The rest are private methods. No user-servicable parts inside.
        
        You shouldn't need to call any of these functions directly.
        
    *********************************************************************************/


    /*
        Calculate the number of days in a month, taking into account leap years.
    */
    function getDaysInMonth($month, $year)
    {
        if ($month < 1 || $month > 12)
        {
            return 0;
        }
   
        $d = $this->daysInMonth[$month - 1];
   
        if ($month == 2)
        {
            // Check for leap year
            // Forget the 4000 rule, I doubt I'll be around then...
        
            if ($year%4 == 0)
            {
                if ($year%100 == 0)
                {
                    if ($year%400 == 0)
                    {
                        $d = 29;
                    }
                }
                else
                {
                    $d = 29;
                }
            }
        }
    
        return $d;
    }


    /*
        Generate the HTML for a given month
    */
    function getMonthHTML($m, $y, $showYear = 1)
    {
        $s = "";
        
        $a = $this->adjustDate($m, $y);
        $month = $a[0];
        $year = $a[1];        
        
    	$daysInMonth = $this->getDaysInMonth($month, $year);
    	$date = getdate(mktime(12, 0, 0, $month, 1, $year));
    	
    	$first = $date["wday"];
    	$monthName = $this->monthNames[$month - 1];
    	
    	$prev = $this->adjustDate($month - 1, $year);
    	$next = $this->adjustDate($month + 1, $year);
    	
    	if ($showYear == 1)
    	{
    	    $prevMonth = $this->getCalendarLink($prev[0], $prev[1]);
    	    $nextMonth = $this->getCalendarLink($next[0], $next[1]);
    	}
    	else
    	{
    	    $prevMonth = "";
    	    $nextMonth = "";
    	}
    	
    	$header = $monthName . (($showYear > 0) ? " " . $year : "");
    	
    	$s .= "<table class=\"calendar\">\n";
    	$s .= "<tr>\n";
    	$s .= "<td align=\"center\" valign=\"top\">" . (($prevMonth == "") ? "&nbsp;" : "<a href=\"$prevMonth\">&lt;&lt;</a>")  . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\" colspan=\"5\">$header</td>\n"; 
    	$s .= "<td align=\"center\" valign=\"top\">" . (($nextMonth == "") ? "&nbsp;" : "<a href=\"$nextMonth\">&gt;&gt;</a>")  . "</td>\n";
    	$s .= "</tr>\n";
    	
    	$s .= "<tr>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay)%7] . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay+1)%7] . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay+2)%7] . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay+3)%7] . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay+4)%7] . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay+5)%7] . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay+6)%7] . "</td>\n";
    	$s .= "</tr>\n";
    	
    	// We need to work out what date to start at so that the first appears in the correct column
    	$d = $this->startDay + 1 - $first;
    	while ($d > 1)
    	{
    	    $d -= 7;
    	}

        // Make sure we know when today is, so that we can use a different CSS style
        $today = getdate(time());
    	
    	while ($d <= $daysInMonth)
    	{
    	    $s .= "<tr>\n";       
    	    
    	    for ($i = 0; $i < 7; $i++)
    	    {
        	    $class = ($year == $today["year"] && $month == $today["mon"] && $d == $today["mday"]) ? "calendarToday" : "calendar";
    	        $s .= "<td class=\"$class\" align=\"right\" valign=\"top\">";       
    	        if ($d > 0 && $d <= $daysInMonth)
    	        {
    	            $link = $this->getDateLink($d, $month, $year);
    	            $s .= (($link == "") ? $d : "<a href=\"$link\">$d</a>");
    	        }
    	        else
    	        {
    	            $s .= "&nbsp;";
    	        }
      	        $s .= "</td>\n";       
        	    $d++;
    	    }
    	    $s .= "</tr>\n";    
    	}
    	
    	$s .= "</table>\n";
    	
    	return $s;  	
    }
    
    
    /*
        Generate the HTML for a given year
    */
    function getYearHTML($year)
    {
        $s = "";
    	$prev = $this->getCalendarLink(0, $year - 1);
    	$next = $this->getCalendarLink(0, $year + 1);
        
        $s .= "<table class=\"calendar\" border=\"0\">\n";
        $s .= "<tr>";
    	$s .= "<td align=\"center\" valign=\"top\" align=\"left\">" . (($prev == "") ? "&nbsp;" : "<a href=\"$prev\">&lt;&lt;</a>")  . "</td>\n";
        $s .= "<td class=\"calendarHeader\" valign=\"top\" align=\"center\">" . (($this->startMonth > 1) ? $year . " - " . ($year + 1) : $year) ."</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" align=\"right\">" . (($next == "") ? "&nbsp;" : "<a href=\"$next\">&gt;&gt;</a>")  . "</td>\n";
        $s .= "</tr>\n";
        $s .= "<tr>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(0 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(1 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(2 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "</tr>\n";
        $s .= "<tr>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(3 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(4 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(5 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "</tr>\n";
        $s .= "<tr>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(6 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(7 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(8 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "</tr>\n";
        $s .= "<tr>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(9 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(10 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(11 + $this->startMonth, $year, 0) ."</td>\n";
        $s .= "</tr>\n";
        $s .= "</table>\n";
        
        return $s;
    }

    /*
        Adjust dates to allow months > 12 and < 0. Just adjust the years appropriately.
        e.g. Month 14 of the year 2001 is actually month 2 of year 2002.
    */
    function adjustDate($month, $year)
    {
        $a = array();  
        $a[0] = $month;
        $a[1] = $year;
        
        while ($a[0] > 12)
        {
            $a[0] -= 12;
            $a[1]++;
        }
        
        while ($a[0] <= 0)
        {
            $a[0] += 12;
            $a[1]--;
        }
        
        return $a;
    }

    /* 
        The start day of the week. This is the day that appears in the first column
        of the calendar. Sunday = 0.
    */
    var $startDay = 0;

    /* 
        The start month of the year. This is the month that appears in the first slot
        of the calendar in the year view. January = 1.
    */
    var $startMonth = 1;

    /*
        The labels to display for the days of the week. The first entry in this array
        represents Sunday.
    */
    var $dayNames = array("S", "M", "T", "W", "T", "F", "S");
    
    /*
        The labels to display for the months of the year. The first entry in this array
        represents January.
    */
    var $monthNames = array("January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December");
                            
                            
    /*
        The number of days in each month. You're unlikely to want to change this...
        The first entry in this array represents January.
    */
    var $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    
}


/************************************************************
 * This page has 4 possible cases:                          *
 * 1.  You're viewing this page without a supplied date,    *
 * so default to Case 4.                                    *
 *                                                          *
 * 2.  There is a date.  This is neither the first nor      *
 * the last entry in the db.                                *
 *                                                          *
 * 3.  There is a date.  This is the first entry in the db. *
 *                                                          *
 * 4.  There is a date.  This is the last entry in the db.  *
 ************************************************************/
      

$PHP_SELF = $_SERVER['PHP_SELF'];

 // Open database connection
 $hostname = "sql112.epizy.com";
 $user = "epiz_28718908";
 $password = "weqmXe12345";

$conn = mysqli_connect($hostname, $user, $password,"epiz_28718908_diario");
$conn -> set_charset("utf8");
//mysql_select_db("nemilloc_diario");
//mysql_set_charset('utf8', $db);
//mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

// Identify the latest entry
$query = "SELECT MAX(ID) FROM gym";
$result = $conn->query($query);
$lastID_row = mysqli_fetch_array($result);
$last_ID = $lastID_row[0];

// Get specified weblog entry
if (!empty($_GET['date'])) {
  $entry_date = $_GET['date'];
  $query1 = "SELECT * FROM gym WHERE fecha = $entry_date";
} else {
  $query1 = "SELECT * FROM gym WHERE ID = $last_ID";
}
$result1 = $conn->query($query1);
$row_test_num = mysqli_num_rows($result1);
if ($row_test_num > 0) {
  $entry_row = mysqli_fetch_array($result1);
  $entry_ID = $entry_row[0];
  $entry_date = $entry_row[1];
  $entry = stripslashes($entry_row[2]);
  $escuchando = stripslashes($entry_row[3]);
  $peso = ($entry_row[12]);
} else {
  // If someone enters a bad date, redirect to homepage
  header("Location: /");
}
//Lee los pesos de los 5 dias anteriores
for ($i = 0; $i < 5; $i++)
{
$prev_ID = $entry_ID - $i;
$query3 = "SELECT * FROM gym WHERE ID = $prev_ID";
$result3 = $conn->query($query3);
$entry3_row = mysqli_fetch_array($result3);
$pesoant[$i] = ($entry3_row[12]);
}

// Get previous date for Cases 2 and 4
if ($entry_ID > 1) {
  $prev_ID = $entry_ID - 1;
  $query2 = "SELECT fecha FROM gym WHERE ID = $prev_ID";
  $result2 = $conn->query($query2);
  $prevdate_row = mysqli_fetch_array($result2);
  $prev_date = $prevdate_row[0];
} else {
  $prev_date = "";
}


// Get next date for Cases 2 and 3
if ($entry_ID != $last_ID) {
  $next_ID = $entry_ID + 1;
  $query3 = "SELECT fecha FROM gym WHERE ID = $next_ID";
  $result3 = $conn->query($query3);
  $nextdate_row = mysqli_fetch_array($result3);
  $next_date = $nextdate_row[0];
} else {
  $next_date = "";
}

// Assemble the Previous/Next links
// Case 2
if ($next_date != "" && $prev_date != "") {
  $flipbar = "\n<P><b>
<A HREF=\"$PHP_SELF?date=$prev_date\"><img style=\"vertical-align:middle\" src=\"flecha_izq.png\" border=0></img>Anterior</A><br><br>
<A HREF=\"$PHP_SELF?date=$next_date\">Siguiente <img style=\"vertical-align:middle\" src=\"flecha_der.png\" border=0></img></A>
</b></P>
\n";
}
// Case 3
elseif ($next_date != "" && $prev_date == "") {
  $flipbar = "\n<P><b>
<A HREF=\"$PHP_SELF?date=$next_date\">Siguiente<img style=\"vertical-align:middle\" src=\"flecha_der.png\" border=0></img></A>
</b></P>\n";
}
// Case 4
elseif($next_date == "" && $prev_date != "") {
  $flipbar = "\n<P><b>
<A HREF=\"$PHP_SELF?date=$prev_date\"> <img style=\"vertical-align:middle\" src=\"flecha_izq.png\" border=0></img> Anterior </A>
</b></P>\n";
}


// ---------------------
// NOW ASSEMBLE THE PAGE
// ---------------------
$title_msg = $entry_date;
$header_msg = "Anotaciones del día $entry_date";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Minimalist Zen Blog: <?php echo $title_msg; ?></title>

<link href="style2.css" rel="stylesheet" type="text/css" title="Zen Blog" />
</head>

<body>
<div id="logo">
	<img src="logo1.png" /></div>

<div id="header">
	<b><h1 class="header">Zen Blog</h1></b>
</div>

<div id="subheader">
	<h1><?php echo $header_msg; ?></h1>
</div>

<div id="lateral">
	<div id="superior" class="superior">
		<img src="esq-sup-izq.jpg" alt="Esquina superior izquierda" class="esquina_sup_izq" />
		<img src="esq-sup-der.jpg" alt="Esquina superior derecha" class="esquina_sup_der" />
	</div>
	<div id="contenido" class="contenido">
		<div id="control" class="control">
			<p><?php
			// Include the specified entry text
			echo $flipbar;
			?> </p><br />
			<?php // Construct a calendar to show the current month 
			$cal = new Calendar; // First, create an array of month names, January through December 
			$spanishMonths = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"); 
			// Then an array of day names, starting with Sunday 
			$spanishDays = array ("D", "L", "M", "X", "J", "V", "S"); 
			$cal->setMonthNames($spanishMonths); $cal->setDayNames($spanishDays); 	
			$cal->setStartDay(1);
			echo $cal->getCurrentMonthView(); ?><br>
		    <a href="db_logentry.php"><h4 style="text-align:center;background-color:#14adff;margin: 40px;padding:10px;">Nueva entrada</h4></a>   <br>
        </div>
        
    </div>
	<div id="inferior" class="inferior">
		<img src="esq-inf-izq.jpg" alt="Esquina inferior izquierda" class="esquina_inf_izq" />
		<img src="esq-inf-der.jpg" alt="Esquina inferior iderecha" class="esquina_inf_der" />
	</div>
</div>

<div id="principal">
	<div id="superior" class="superior">
		<img src="esq-sup-izq.jpg" alt="Esquina superior izquierda" class="esquina_sup_izq" />
		<img src="esq-sup-der.jpg" alt="Esquina superior derecha" class="esquina_sup_der" />
	</div>
	<div id="contenido" class="contenido">
		<div id="control" class="control">
			<p><b>En general</b><br />
			<?php
			// Include the specified entry text
			echo $entry;
			?></p>
			<p><b>Escuchando</b><br />
			<?php
			// Include the escuchando row
			echo $escuchando;
			?></p><br />
			<b>Peso</b><br />
			<div id="vertgraph">
    <ul>
        <li class="info" style="height: <?php echo 190*$peso/100;?>px;"><?php echo $peso;?></li>
    <li class="low" style="height:  <?php echo 190*$pesoant[1]/100;?>px;"><?php echo $pesoant[1];?></li>
	<li class="medium" style="height: <?php echo 190*$pesoant[2]/100;?>px;"><?php echo $pesoant[2];?></li>
	<li class="high" style="height: <?php echo 190*$pesoant[3]/100;?>px;"><?php echo $pesoant[3];?></li>
	<li class="critical" style="height: <?php echo 190*$pesoant[4]/100;?>px;"><?php echo $pesoant[4];?></li>
    </ul>
</div>
			
		</div>
	</div>
	<div id="inferior" class="inferior">
		<img src="esq-inf-izq.jpg" alt="Esquina inferior izquierda" class="esquina_inf_izq" />
		<img src="esq-inf-der.jpg" alt="Esquina inferior iderecha" class="esquina_inf_der" />
	</div>
</div>
</body>
</html>
