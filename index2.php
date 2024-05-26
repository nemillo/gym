<?php

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
      
// Open database connection
$hostname = "nemilloc.dot5hostingmysql.com";
$user = "nemilloc_jefe";
$password = "r3230op";

mysql_connect($hostname, $user, $password);
mysql_select_db("nemilloc_diario");

// Identify the latest entry
$query = "SELECT MAX(ID) FROM gym";
$result = mysql_query($query);
$lastID_row = mysql_fetch_array($result);
$last_ID = $lastID_row[0];

// Get specified weblog entry
if ($_GET['date'] != "") {
  $entry_date = $_GET['date'];
  $query1 = "SELECT * FROM gym WHERE fecha = $entry_date";
} else {
  $query1 = "SELECT * FROM gym WHERE ID = $last_ID";
}
$result1 = mysql_query($query1);
$row_test_num = mysql_num_rows($result1);
if ($row_test_num > 0) {
  $entry_row = mysql_fetch_array($result1);
  $entry_ID = $entry_row[0];
  $entry_date = $entry_row[1];
  $entry = stripslashes($entry_row[2]);
  $escuchando = stripslashes($entry_row[3]);
} else {
  // If someone enters a bad date, redirect to homepage
  header("Location: /index.php");
}

// Get previous date for Cases 2 and 4
if ($entry_ID > 1) {
  $prev_ID = $entry_ID - 1;
  $query2 = "SELECT fecha FROM gym WHERE ID = $prev_ID";
  $result2 = mysql_query($query2);
  $prevdate_row = mysql_fetch_array($result2);
  $prev_date = $prevdate_row[0];
} else {
  $prev_date = "";
}

// Get next date for Cases 2 and 3
if ($entry_ID != $last_ID) {
  $next_ID = $entry_ID + 1;
  $query3 = "SELECT fecha FROM gym WHERE ID = $next_ID";
  $result3 = mysql_query($query3);
  $nextdate_row = mysql_fetch_array($result3);
  $next_date = $nextdate_row[0];
} else {
  $next_date = "";
}

// Assemble the Previous/Next links
// Case 2
if ($next_date != "" && $prev_date != "") {
  $flipbar = "\n<P CLASS=\"anterior\">
<A HREF=\"$PHP_SELF?date=$prev_date\">&#60;-- Anterior</A>
<A HREF=\"$PHP_SELF?date=$next_date\">Siguiente --&#62;</A>
</P>
\n";
}
// Case 3
elseif ($next_date != "" && $prev_date == "") {
  $flipbar = "\n<P CLASS=\"siguiente\">
<A HREF=\"$PHP_SELF?date=$next_date\">Siguiente --&#62;</A>
</P>\n";
}
// Case 4
elseif($next_date == "" && $prev_date != "") {
  $flipbar = "\n<P CLASS=\"anterior\">
<A HREF=\"$PHP_SELF?date=$prev_date\">&#60;-- Anterior</A>
</P>\n";
}


// ---------------------
// NOW ASSEMBLE THE PAGE
// ---------------------
$title_msg = $entry_date;
$header_msg = "Anotaciones del día $entry_date";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta name="Author" content="Rafael Olona" />
 <meta name="keywords" content="Zen Blog Design" />
 <meta name="description" content="Zen Blog PHP MySql powered" />
 <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Minimalist Zen Blog: <?php echo $_GET['date']; ?></title>

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

			<p><br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<?php
			// Include the specified entry text
			
			echo $flipbar;
			?></p>

</div>

<div id="principal">
	<div id="superior" class="superior">
		<img src="esq-sup-izq.jpg" alt="Esquina superior izquierda" class="esquina_sup_izq" />
		<img src="esq-sup-der.jpg" alt="Esquina superior derecha" class="esquina_sup_der" />
	</div>
	<div id="contenido" class="contenido">
		<div id="control" class="control">
			<p><?php
			// Include the specified entry text
			echo $entry;
			?></p>
			<p><?php
			// Include the escuchando row
			echo $escuchando;
			?></p>
		</div>
	</div>
	<div id="inferior" class="inferior">
		<img src="esq-inf-izq.jpg" alt="Esquina inferior izquierda" class="esquina_inf_izq" />
		<img src="esq-inf-der.jpg" alt="Esquina inferior iderecha" class="esquina_inf_der" />
	</div>
</div>
</body>
</html>
