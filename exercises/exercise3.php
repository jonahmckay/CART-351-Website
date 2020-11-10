<?php
//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'GET')
{

//code modified from https://www.codegrepper.com/code-examples/php/append+data+to+json+file+php
if (isset($_GET["name"]))
{
  $data = $_GET;

  if (isset($_GET["natural"]))
  {
    $_GET["natural"] = true;
  }
  else
  {
    $_GET["natural"] = false;
  }
  $data["colourWords"] = array($data["colourWords"]);

  $exerciseData = file_get_contents('exercise3data.json');
  $tempArray = json_decode($exerciseData);
  array_push($tempArray, array($data));
  $jsonData = json_encode($tempArray);
  file_put_contents('exercise3data.json', $jsonData);

  header("Location:exercise3.php");
}


}
?>

<html>


<head>
  <title>EXERCISE 2</title>
  <meta charset="UTF-8">
  <style>
    html
    {
      font-family: sans-serif;
    }
    #searchResults
    {
      width: 100%;
      display: flex;
      flex-wrap: wrap;
      flex-direction: row;
    }
    .infobox
    {
      width: 15em;
      margin: 5px;
      padding:5px;
      border: 1px solid black;
    }
    .descriptionInput
    {
      height: 4em;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
  "use strict"

  let jsonData;
  $.getJSON("./exercise3data.json",
    function(data)
    {
        jsonData = data;
        console.log($("#numberOfDays"))
        $("#numberOfDays").text(jsonData.length);
        $("#dayFilterValue").max = jsonData.length;
        console.log("json loaded")
        search();
    }
  ).fail( function ()
  {
    console.error("could not load json");
  });

  function dayFilterUpdate()
  {
    let checked = !$("#dayFilterBox").is(':checked')
    $("#dayFilterValue").prop("disabled", checked);
    $("#dayFilterOperation").prop("disabled", checked);
  }

  function sizeFilterUpdate()
  {
    let checked = !$("#sizeFilterBox").is(':checked')
    $("#sizeFilterValue").prop("disabled", checked);
    $("#sizeFilterOperation").prop("disabled", checked);
  }

  function starFilterUpdate()
  {
    let checked = !$("#starFilterBox").is(':checked')
    $("#starFilterValue").prop("disabled", checked);
    $("#starFilterOperation").prop("disabled", checked);
  }

  function search()
  {
    let resultsDiv = $("#searchResults");
    resultsDiv.empty();

    let knickknacks = [];
    let filteredKnickknacks = []

    let dayOperation = $("#dayFilterOperation option:selected").val();
    let dayFilterValue = $("#dayFilterValue").val();

    for (let i = 0; i < jsonData.length; i++)
    {
      let validDay = true;
      if ($("#dayFilterBox").is(':checked'))
      {
        if (dayOperation === "before" && i+1 >= dayFilterValue)
        {
          validDay = false;
        }
        else if (dayOperation === "specifically" && i+1 !== parseInt(dayFilterValue))
        {
          validDay = false;
        }
        if (dayOperation === "after" && i+1 <= dayFilterValue)
        {
          validDay = false;
        }
      }

      if (validDay)
      {
        let dayContents = jsonData[i];
        for (let dayi = 0; dayi < dayContents.length; dayi++)
        {
          knickknacks.push(dayContents[dayi]);
        }
      }
    }

    let sizeFilterOperation = $("#sizeFilterOperation option:selected").val();
    let sizeFilterValue = $("#sizeFilterValue").val();

    let starFilterOperation = $("#starFilterOperation option:selected").val();
    let starFilterValue = parseInt($("#starFilterValue").val());

    for (let i = 0; i < knickknacks.length; i++)
    {
      let acceptable = true;

      if ($("#sizeFilterBox").is(':checked'))
      {
        if (sizeFilterOperation === "less than" && knickknacks[i].size > sizeFilterValue)
        {
          acceptable = false;
        }
        if (sizeFilterOperation === "greater than" && knickknacks[i].size < sizeFilterValue)
        {
          acceptable = false;
        }
      }
      console.log(starFilterValue)
      if ($("#starFilterBox").is(':checked'))
      {
        if (starFilterOperation === "less than" && knickknacks[i].starRating >= parseInt(starFilterValue))
        {
          acceptable = false;
        }
        if (starFilterOperation === "greater than" && knickknacks[i].starRating <= parseInt(starFilterValue))
        {
          acceptable = false;
        }
      }

      if (!$("#naturalFilterBox").is(':checked') && knickknacks[i].natural)
      {
        acceptable = false;
      }

      if (!$("#artificialFilterBox").is(':checked') && !knickknacks[i].natural)
      {
        acceptable = false;
      }
      if (acceptable)
      {
        filteredKnickknacks.push(knickknacks[i])
      }
    }
    console.log(filteredKnickknacks)

    for (let i = 0; i < filteredKnickknacks.length; i++)
    {
      let item = filteredKnickknacks[i];

      let infoBox = $("<div class='infobox'></div>");
      let title = $(`<h2>${item.name}</h2>`);
      let description = $(`<p>${item.description}</p>`);

      let attributesBar = $("<div class='attributes'></div>");

      if (!item.natural)
      {
        attributesBar.append($("<img src='./exercise2images/artificial.png' alt='This knickknack is of artificial origin'></img>"));
      }
      else
      {
        attributesBar.append($("<img src='./exercise2images/natural.png' alt='This knickknack is of natural origin'></img>"));
      }

      attributesBar.append($(`<span>${item.dateFound},</span>`));
      attributesBar.append($(`<span> size: ${item.size}</span>`));

      let coloursBar = $("<div class='colours'></div>");

      let coloursString = "";
      if (item.colourWords.length === 0)
      {
        coloursString = "colourless, somehow";
      }
      else
      {
        for (let i = 0; i < item.colourWords.length; i++)
        {
          coloursString += item.colourWords[i];
          if (i < item.colourWords.length-1)
          {
            coloursString += ", ";
          }
        }
      }

      coloursBar.append($(`<p>${coloursString}</p>`));

      let starBar = $("<div class='stars'></div>");

      for (let i = 0; i < item.starRating; i++)
      {
        starBar.append($("<img src='./exercise2images/star.png' alt='A star' width=32>"));
      }
      infoBox.append(title);
      infoBox.append(description);
      infoBox.append(attributesBar);
      infoBox.append(coloursBar);
      infoBox.append(starBar);

      $('#searchResults').append(infoBox);
    }
  }
  </script>
</head>

<body>
  <h1>Knickknacks Searcher</h1>
  <input type="checkbox" id="dayFilterBox" onchange=dayFilterUpdate()></input>
  Day Filter:
  <select type="text" disabled=true id="dayFilterOperation">
    <option>before</option>
    <option>specifically</option>
    <option>after</option>
  </select>
  day
  <input type="number" disabled=true min=1 max=4 value=1 id="dayFilterValue">
  of <span id="numberOfDays">?</span>
  </input>

  </br>

  <input type="checkbox" id="sizeFilterBox" onchange=sizeFilterUpdate()></input>
  Size Filter:
  <select type="text" disabled=true id="sizeFilterOperation">
    <option>less than</option>
    <option>greater than</option>
  </select>
  <input type="number" disabled=true min=0 max=10 value=1 id="sizeFilterValue">
  </input>

  </br>

  <input type="checkbox" id="starFilterBox" onchange=starFilterUpdate()></input>
  Star Filter:
  <select type="text" disabled=true id="starFilterOperation">
    <option>less than</option>
    <option>greater than</option>
  </select>
  <input type="number" min=1 max=5 value=3 disabled=true id="starFilterValue">
  </input>
  </br>
  Natural objects: <input type="checkbox" checked=true id="naturalFilterBox"></input>
  Artificial objects: <input type="checkbox" checked=true id="artificialFilterBox"></input>
  </br>
  <button id="queryButton" onclick="search()">Query</button>
  <h3>Results:</h3>
  <div id="searchResults"> Make a query!

  </div>
  <div id="formWrapper">
    <h2>Add a knickknack!</h2>
    <form method="get" action="exercise3.php">
      <p><label>Title</label><input type = "text" size="24" maxlength = "40"  name = "name" required></p>
      <p><label>Description</label><input class="descriptionInput" type = "text" size="24" maxlength = "400"  name = "description" required></p>
      <p><label>Colours</label><input type = "text" size="24" maxlength = "400"  name = "colourWords" required></p>
      <p><label>Date</label><input type = "text" size="24" maxlength = "400"  name = "dateFound" required></p>
      <p><label>Size</label><input type = "number" size="24" maxlength = "40" step="any" name = "size" min="0.001" max="100" required></p>
      <p><label>Rating</label><input type = "number" size="24" maxlength = "40"  name = "starRating" min="1" max="5" required></p>
      <p><label>Natural?</label><input type = "checkbox" name = "natural"></p>

      <p><input type = "submit" name = "submit" value = "send" id =button /></p>

    </form>
  </div>
</body>
</html>
