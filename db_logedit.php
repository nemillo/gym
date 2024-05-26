<?php
$hostname = "sql112.epizy.com";
$user = "epiz_28718908";
$password = "weqmXe12345";

mysql_connect($hostname, $user, $password);
mysql_select_db("epiz_28718908_diario");

// Validate this user
$test_username = $_POST['test_username'];
$query = "SELECT password
          FROM login
          WHERE username = '$test_username'";
$result = mysql_query($query);
if (mysql_num_rows($result) != 1) {
  echo "Something is wrong";
  exit;
}
$password_row = mysql_fetch_array($result);
$db_password = $password_row[0];

if ($_POST['test_password'] == $db_password &&
  $_POST['test_password'] != "") {
  if ($_POST['Submit'] == 'Enter') {
    // Insert edited entry
    $edit_date = $_POST['edit_date'];
    // Escape single-quotes and apostrophes
    $blogtext = addslashes($_POST['blogtext']);
    $query = "UPDATE mylog SET blogtext = '$blogtext'
              WHERE date = $edit_date";
    $result = mysql_query($query);
    if (mysql_affected_rows() == 1) {
      header("Location: db_login.php");
    } else {
      echo "There was a problem inserting your text.";
      exit;
    }
  } else {
    // Show the form with the appropriate entry filled in
    $php_self = $_SERVER['PHP_SELF'];
    $test_password = $_POST['test_password'];
    $edit_date = $_POST['edit_date'];
    $query = "SELECT blogtext FROM mylog
              WHERE date = $edit_date";
    $result = mysql_query($query);
    if (mysql_num_rows($result) == 0) {
      echo "No entry matches that date";
      exit;
    }
    $entry_row = mysql_fetch_array($result);
    // When you get text from a SQL database,
    // you may need to strip backslashes from single-quotes.
    $blogtext = stripslashes($entry_row[0]);

$form_str = <<< EOFORMSTR
<HTML>
<HEAD>
<TITLE>Weblog data edit screen</TITLE>
</HEAD>
<BODY>
<FORM ACTION="$php_self" METHOD="POST">
<P>Text:<BR>
<TEXTAREA NAME="blogtext" COLS=75 ROWS=20
WRAP="VIRTUAL">$blogtext</TEXTAREA></P>
<INPUT TYPE="hidden" NAME="test_username"
VALUE="$test_username">
<INPUT TYPE="hidden" NAME="test_password"
VALUE="$test_password">
<INPUT TYPE="hidden" NAME="edit_date" VALUE="$edit_date">
<P><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="Enter"></P>
</FORM>
</BODY>
</HTML>
EOFORMSTR;
    echo $form_str;
  }
} else {
  mail("me@nemilloc.dot5hostingmysql.com", "Weblog snoop", "Someone from
$REMOTE_ADDR is trying to get into your weblog entry screen.");
}
?>