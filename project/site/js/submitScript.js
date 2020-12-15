function randomizeRecipient()
{
  recipients = ["a pigeon",
   "Carl",
   "a piece of driftwood",
   "???",
   "the person reading this",
   "myself",
   "a random number generator",
   "a lamp",
   "a discarded keyboard",
   "an astrolabe",
   "Spidey, the spider plant",
   ":)",
   "hedgehog",
   "The Sun",
   "The Moon",
   "Alpha Centauri"];
  recipient = recipients[Math.floor(Math.random()*recipients.length)];
  $("#recipientName").val(recipient);
}

function submitFile()
{
  $('#file-input').trigger('click');
}

function fileAttached(e)
{
  console.log(e[0].name);
  $('#attachmentName').text(`Attachment: ${e[0].name}`);
}

function sendMessage()
{
  alert("Message sent!");
  window.location.href = "index.html"
}
