//results stores the query results

window.addEventListener('load', function () {
  populatePanels();
})

function populatePanels()
{

  for (let i = 0; i < results.length; i++)
  {
    console.log("???");
    senderPara = $(`<p>Sender: ${results[i]["senderName"]}</p>`);
    recipientPara = $(`<p>Recipient: ${results[i]["messageRecipient"]}</p>`);
    descriptionPara = $(`<p>Description: ${results[i]["description"]}</p>`);
    datePara = $(`<p>Date Sent: ${results[i]["timeSent"]}</p>`);

    mysteryPanel = $("<div class='mysteryPanel'></div>");
    mysteryPanelText = $("<div class='mysteryPanelText'></br></div>");
    mysteryPanelImage = $("<div class='mysteryPanelImage'></div>");

    mysteryPanelText.append(senderPara);
    mysteryPanelText.append(recipientPara);
    mysteryPanelText.append(descriptionPara);
    mysteryPanelText.append(datePara);

    mysteryPanel.append(mysteryPanelText);
    mysteryPanel.append(mysteryPanelImage);

    $("#mysteryPanelContainer").append(mysteryPanel);
    console.log(mysteryPanel);
  }
}
