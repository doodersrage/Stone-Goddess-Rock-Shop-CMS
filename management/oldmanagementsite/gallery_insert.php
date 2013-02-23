<?
if(is_uploaded_file($_FILES['image']['tmp_name']))
{
  // file uploaded to server
  echo "file information is :-<br />";
  print_r($_FILES);

     $imageInfo = getimagesize($_FILES['image']['tmp_name']);
     $width = $imageInfo[0];
     $height = $imageInfo[1]; 
     $image_type = $imageInfo[2];
     print_r($imageInfo);

  move_uploaded_file($_FILES['form_image']['tmp_name'], "./tempfile/".$_FILES['form_image']['name']);

//Insert record into database
$insert_data = "INSERT INTO gallery VALUE
                      ('', '$imageInfo' , '$imageDescription')";
}
else
{
     echo "No image was uploaded!";
}     
          
if (mysql_query($insert_data,$db)) {
echo "Record added";
}
else {
echo "No record was added";
}
?>