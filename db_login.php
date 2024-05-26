<HTML>
<HEAD>
<TITLE>Weblog login screen</TITLE>
</HEAD>

<P><B>Use this login to add a new entry.</B></P>
<FORM METHOD=POST ACTION="db_logentry.php">
<P>USERNAME:<INPUT TYPE=TEXT NAME="test_username" SIZE=20></P>
<P>PASSWORD:<INPUT TYPE=PASSWORD NAME="test_password" SIZE=20></P>
<P><INPUT TYPE="SUBMIT" VALUE="SUBMIT">
</FORM>

<P><B>Use this login to edit a previous entry.</B></P>
<FORM METHOD=POST ACTION="db_logedit.php">
<P>USERNAME:<INPUT TYPE=TEXT NAME="test_username" SIZE=20></P>
<P>PASSWORD:<INPUT TYPE=PASSWORD NAME="test_password" SIZE=20></P>
<P>EDIT DATE:<INPUT TYPE=TEXT NAME="edit_date" SIZE=8></P>
<P><INPUT TYPE="SUBMIT" VALUE="SUBMIT">
</FORM>
</BODY>
</HTML>