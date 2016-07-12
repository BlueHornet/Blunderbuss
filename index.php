<!DOCTYPE html>
<html>
<head>
    <title>Blunderbuss - Simple Mail Blasts</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="index.js"></script>
    <link rel="stylesheet" type="text/css" href="index.css" />
</head>
<body>
<h1>Blunderbuss</h1>
<h2 class="subtitle">Simple Mail Blasts</h2>
<form id="blunderbuss" name="blunderbuss" action="send.php" method="post">
    <fieldset>
        <legend>MTA Relay Info</legend>
        <div id="relayHostDiv">
            <label for="relayHost">Relay Host</label>
            <input type="text" id="relayHost" name="relayHost" />
        </div>
        <div id="relayUserDiv">
            <label for="relayUser">Relay Username</label>
            <input type="text" id="relayUser" name="relayUser" />
        </div>
        <div id="relayPassDiv">
            <label for="relayPass">Relay Password</label>
            <input type="text" id="relayPass" name="relayPass" />
        </div>
    </fieldset>
    <fieldset>
        <legend>Message Data</legend>
        <textarea id="messageData" name="messageData">
{
  "template": "From: {{ fromname }} <{{ fromaddr }}>\r\nTo: {{ toaddr }}\r\nSubject: {{ subject }}\r\n\r\nHello World",
  "defaults": { 
    "fromname": "Mail Sender",
    "fromaddr": "sender@example.com",
    "subject": "Email blast"
  },
  "recipients": [
    {
      "toaddr": "john@example.org"
    },
    {
      "toaddr": "jane@example.org"
    },
    {
      "toaddr": "spot@example.org",
      "fromname": "Super Emailer"
    }
  ]
}
        </textarea>
    </fieldset>
    <input type="submit" value="Send" />
</form>
</body>
</html>