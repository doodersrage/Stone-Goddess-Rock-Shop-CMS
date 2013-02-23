<?PHP
if ($_SESSION["loginadminokay"] == 1 && ($_SESSION["admin"]== 1 || $_SESSION["admin"] == 2)) { ?>
<?PHP 
// add email address
if ($_POST["bsubmit"] === "Add") {
if ($_SESSION["admin"] == 1) {
$check_query = mysql_query("SELECT email FROM newsletter_list WHERE email = '".$_POST['new_email']."';");
$found_email_cnt = mysql_num_rows($check_query);

if (empty($found_email_cnt)) {
mysql_query("INSERT INTO newsletter_list (email) VALUES ('".$_POST['new_email']."');");
$Marque = "Email address added to mailing list.";
} else {
$Marque = "Email address already exists within mailing list.";
}

}
}

// remove email address
if ($_POST["bsubmit"] === "Delete") {
if ($_SESSION["admin"] == 1) {

mysql_query("DELETE FROM newsletter_list WHERE email_id = '".$_POST['managesel']."';");
$Marque = "Email address was removed from the mailing list.";
}
}

if ($_POST["bsubmit"] === "Submit") {
if ($_SESSION["admin"] == 1) {

$getlistingresult = mysql_query("SELECT email FROM newsletter_list ORDER BY email ASC");
while ($getlisting = @mysql_fetch_array($getlistingresult)) {

// send email
$comment = $_POST['descri'];
$subject = $_POST['subject'];

//add From: header
$headers = "From: newsletter@stonegoddess.com\r\n";

//specify MIME version 1.0
$headers .= "MIME-Version: 1.0\r\n";

//unique boundary
$boundary = uniqid("HTMLEMAIL");

//tell e-mail client this e-mail contains//alternate versions
$headers .= "Content-Type: multipart/alternative; boundary = $boundary\r\n\r\n";

//plain text version of message
$body = "--$boundary\r\n" .
   "Content-Type: text/plain; charset=ISO-8859-1\r\n" .
   "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= chunk_split(base64_encode(strip_tags($comment)));

//HTML version of message
$body .= "--$boundary\r\n" .
   "Content-Type: text/html; charset=ISO-8859-1\r\n" .
   "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= chunk_split(base64_encode($comment));

//send message
mail($getlisting['email'], $subject, $body, $headers);

}
//autosend newsletter
//Set mailmsg = Server.CreateObject("CDONTS.NewMail")
//
//mailmsg.From = "webmaster@stonegoddess.com"
//mailmsg.To = "NewsLetter@stonegoddess.com"
//mailmsg.Subject = request.form("subject")
//
//emailmsgstr = "<!DOCTYPE HTML PUBLIC ""-//W3C//DTD HTML 4.01 Transitional//EN"" ""http://www.w3.org/TR/html4/loose.dtd"">"
//emailmsgstr = emailmsgstr & "<html><head><title>" & request.form("subject") & "</title>"
//emailmsgstr = emailmsgstr & "<meta http-equiv=""Content-Type"" content=""text/html; charset=iso-8859-1"">"
//emailmsgstr = emailmsgstr & "</head>"
//emailmsgstr = emailmsgstr & "<body bgcolor=""#ffffcc"">"
//emailmsgstr = emailmsgstr & request.form("Descri")
//emailmsgstr = emailmsgstr & "</body></html>"
//
//mailmsg.Body = emailmsgstr
//
//mailmsg.MailFormat = 0
//mailmsg.BodyFormat = 0
//
//mailmsg.Send
//Set mailmsg = Nothing
$Marque = "Newsletter has been sent";
} else {
$Marque="You do not have the privileges to update or post in this form.";
}
}

?>
<strong></strong>
<div align="center"></div>
<div align="center"><font color="#FF0000"><strong><?=$Marque?></strong></font></div>
  
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td rowspan="2" valign="top" width="650">
<form name="form1" method="post" action="">
        <fieldset><legend><strong><font color="#FF0000">Send NewsLetter:</font></strong> </legend>
		Subject:<br />
        <input name="subject" type="text" size="75">
        <br />
        NewsLetter :<br />
        <?PHP
		$oFCKeditor = new FCKeditor('descri') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Value = '';
		$oFCKeditor->Create();
		?>
        <br />
        <input type="submit" name="bsubmit" value="Submit">
      </fieldset>
	  </form></td>
    <td valign="top"><form action="" method="post" name="form2" id="form2">
      <fieldset>
      <legend><strong>View/Change Current Items:</strong></legend>
        Email<br />
      <select name="managesel" size="10">
        <?PHP
		$getlistingresult = mysql_query("SELECT email_id, email FROM newsletter_list ORDER BY email ASC");
		  while ($getlisting = @mysql_fetch_array($getlistingresult)) {
		  ?>
        <option value="<?php echo $getlisting["email_id"]?>"> <?PHP echo $getlisting["email"]; ?> </option>
        <?PHP } ?>
      </select>
      <br />
      <input type="submit" name="bsubmit" value="Delete" onclick='return confirm(&quot;Are you sure you want to delete this item?&quot;)' />
      </fieldset>
    </form>
    <table border="0" align="right">
        <tr> 
          <td valign="bottom"><font color="#00FF66" size="3"><strong></strong></font> 
            <form name="form1" ACTION = "" METHOD = "POST">
              <fieldset>
              <legend><strong>Add new email to mailing list here.</strong></legend>
              <input type=hidden name="recipient2" value="NewsLetter-request@stonegoddess.com">
              <input type=hidden name="subject2" value="subscribe">
              <input type="text" name="new_email">
              <input type=hidden name="redirect2" value="http://stonegoddess.com/management/default.asp?P=3">
              <input type="submit" name="bsubmit" value="Add">
			  </fieldset>
            </form></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?PHP
} else {
?>
You either do not have privileges to this page or you have not logged in. <a href="http://stonegoddess.com/management/?logout=1">Click
here to login.</a>
<?PHP
}
?>