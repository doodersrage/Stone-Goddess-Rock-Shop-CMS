<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="gallery_insert.php" method="post" enctype="multipart/form-data">
  <p>Note: All fields are mandatory / compulsory. Please fill them all up.
  </p>
  <p>Description:<br />
    <textarea name="imageDescription" rows=4 cols=70></textarea>
  </p>
  <p>Upload a photo(gif/jpeg format) for this event: <br />
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
    <input name="image" type="file" size="70">
  </p>
  <p>
    <input type="submit" value="Send this file!">
  </p>
</form>
</body>
</html>
