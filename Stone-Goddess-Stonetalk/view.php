<?php
  include 'db.inc';

  if (empty($file))
     exit;

  if (!($connection = @ mysql_pconnect($hostName,
                                       $username,
                                       $password)))
     showerror();

  if (!mysql_select_db("stonegoddess_com", $connection))
     showerror();

  $query = "SELECT * FROM binary_data 
            WHERE filename = '$file'";

  if (!($result = @ mysql_query ($query,$connection)))
     showerror();  

  $data = @ mysql_fetch_array($result);

  if (!empty($data["bin_data"]))
  {
    // Output the MIME header
     header("Content-Type: {$data["filetype"]}");
    // Output the image
     echo $data["bin_data"];
   }
?>