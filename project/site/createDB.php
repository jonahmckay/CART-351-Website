<?php
 require('openDB.php');

 try{
$theQuery = "CREATE TABLE messages (messageID INTEGER PRIMARY KEY NOT NULL,
  senderName TEXT,
  description TEXT,
  messageRecipient TEXT,
  messageRecipientID INTEGER,
  body TEXT,
  timeSent TEXT,
  fileName TEXT)";
$file_db ->exec($theQuery);
echo ("Table messages created successfully<br>");
$file_db = null;
}
catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>
