<!DOCTYPE html>
<html lang="" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="./js/submitScript.js"></script>
    <title>File Over Ocean Protocol</title>
  </head>
  <body class="submitBody">

  <div class="constrictBox">
    <div id="instructions">
      <h2>Instructions:</h2>
      <p>Provide a name for yourself, which can be any semi-unique identifier.</p>
      <p>Either think of something or someone to send a message to, or let random chance decide for you.</p>
      <p>When writing your message, keep in mind the medium of the message, but otherwise consider it a free writing prompt.</p>
    </div>


    <div id="submitDiv">
      <form enctype="multipart/form-data" action="./submitMessage.php" method="post">
      <fieldset>
        <label for="senderName">Your name:</label>
        <input type="text" id="senderName" type="text" size="24" maxlength = "80" name ="senderName" required></input> </br>
        <label for="recipientName">Recipients name:</label>
        <input type="text" id="recipientName" type="text" size="24" maxlength = "80" name = "recipientName" required></input>
        <button id="randomRecipient" type="button" onclick="randomizeRecipient()">Random</button></br>
        <textarea rows="20" cols="80" type="text" maxlength = "40000" name = "messageText" required></textarea> </br>
        <span id="attachmentName">Attachment: None</span></br>
        <button id="attachment" type="button" onclick="submitFile()">Add attachment (5 MB limit)</button>
        <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
        <input id="file-input" type="file" name="fileInput" onchange="fileAttached(this.files)" style="display: none;" name="attachment"/>
      </br><label for="description">Short description:</label>
        <input type="text" id="description" size="48" maxlength = "120" name="messageDescription"></input> </br></br>
        <button id="submit" onclick="sendMessage()" type = "submit">Send Message</button>
      </fieldset>
    </div>
  </div>
  </body>
</html>
