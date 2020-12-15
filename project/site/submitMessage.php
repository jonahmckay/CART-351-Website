<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  require('openDB.php');
  $description = $_POST['messageDescription'];
  $senderName = $_POST['senderName'];
  $messageRecipient = $_POST['recipientName'];
  $messageRecipientID = NULL;
  $messageBody = $_POST['messageText'];

  $date = new DateTime();
  $timeSent = date_format($date, 'Y-m-d');

  try
  {
    $fileName = basename($_FILES["fileInput"]["name"]);
  }
  catch (PDOException $e)
  {
    $fileName = NULL;
  }

  //file stuff
  //code adapted from https://www.w3schools.com/php/php_file_upload.asp

  $target_dir = "../../../../db/uploads/";
  $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);
  $uploadOk = 1;

  if ($_FILES["fileInput"]["size"] > 5242880) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
//    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
  //    echo "The file ". htmlspecialchars( basename( $_FILES["fileInput"]["name"])). " has been uploaded.";
    } else {
  //    echo "Sorry, there was an error uploading your file.";
    }

  $insertQuery = "INSERT INTO messages (description,
    senderName,
    messageRecipient,
    messageRecipientID,
    body,
    timeSent,
    fileName) VALUES (:description,
      :senderName,
      :messageRecipient,
      :messageRecipientID,
      :messageBody,
      :timeSent,
      :fileName)";

  $statement = $file_db->prepare($insertQuery);
  $statement->bindValue(":senderName", $senderName);
  $statement->bindValue(":messageRecipient", $messageRecipient);
  $statement->bindValue(":messageRecipientID", $messageRecipientID);
  $statement->bindValue(":messageBody", $messageBody);
  $statement->bindValue(":timeSent", $timeSent);
  $statement->bindValue(":fileName", $fileName);

  $statement->execute();

}
}
?>

<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./style/style.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <script>
  let messageText = "<?php echo $messageBody ?>"
  </script>
  <script src="./js/uploadAnimationScript.js"></script>
  <title>File Over Ocean Protocol</title>
</head>

<body class="uploadingBody">
  <div class="centerDiv">
    <div class="uploadingHeader">
      <h1>Uploading message...</h1>
    </div>
    <div id="textBox"></div>
    <p id="returnLink"><a href="index.php">Go back to home</a> or <a href="submit.php">submit a new message</a></p>
  </div>
</body>

</html>
