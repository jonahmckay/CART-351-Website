<?php
  require("openDB.php");

  $query = "SELECT senderName, messageRecipient, description, timeSent FROM messages WHERE messageID IN (SELECT messageID FROM messages ORDER BY RANDOM() LIMIT 3)";

  try
  {
      $result = json_encode($file_db->query($query)->fetchAll());
  }
  catch (PDOException $e)
  {
    die("query failed, table likely does not exist. Try opening createDB.php to create the table");
  }

    //$jsonArray[] = $row;
?>

<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./style/style.css">
  <title>File Over Ocean Protocol</title>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <script>
  let results = <?php echo $result ?>;
  console.log(results);
  </script>

  <script src="./js/exploreCode.js"></script>

</head>
<body class="exploreBody">
  <div class="centerDiv">

  <div id="exploreHeader">
  <h1>Explore</h1>
  </div>
  <p>Before you write your own message, you can get a glimpse of what other people have been sending...</p>

</div>
  <div id="mysteryPanelContainer">
  </div>
  <div class="divider"></div>
  <div class="centerDiv">
    <button class="toSubmissionButton fancyButton" onclick="location.href='./submit.php'" type="button">Proceed</button>
  </div>
</body>
</html>
