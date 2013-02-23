<?PHP
require('includes/dbconfig.php');

$lines = file('emaillist.csv');

//foreach ($lines as $line_num => $line) {
//  $line_data = trim(str_replace("'","''",$line));
//  mysql_query("INSERT INTO newsletter_list (email) VALUES ('".$line_data."');");
//  echo $line_data.' Inserted into database<br>';
//}

?>
