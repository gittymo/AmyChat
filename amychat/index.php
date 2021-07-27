<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" dir="ltr">
<head>
<title>Amy Chat - Developed By Morgan Evans</title>
<link href="./default.css" rel="stylesheet" type="text/css" />
<script src="./utils.js"></script>
<script type="text/javascript">
	var recReq, userReq;
	
	function init() {
		getElement("userName").value = getCookie("userName");
		getElement("colourBox").selectedIndex = getCookie("colour");
	}
	
	function sendMessage() {
		var httpReq = getAjaxRequest();
		if (httpReq != null) {
			var urlString = "./postmessage.php?uname=" + 
				escape(getElement("userName").value) +
				"&col=" + escape(getElement("colourBox").value) +
				"&msg=" + escape(stripHTMLFromMessage());
			httpReq.open("GET",urlString,true);
			httpReq.send(null);
		}
		
		var msgBox = getElement("messageBox");
		msgBox.value = "";
		msgBox.focus();
		
		setCookie("userName",getElement("userName").value,31);
		setCookie("colour",getElement("colourBox").value,31);
	}
	
	function getMessages() {
		recReq = getAjaxRequest();
		if (recReq != null) {
			recReq.open("GET","./getmessages.php?uname=" + 
				escape(getElement("userName").value),true);
			recReq.send(null);
			recReq.onreadystatechange=displayMessages;
		}
	}
	
	function updateUsers() {
		userReq = getAjaxRequest();
		if (userReq != null) {
			userReq.open("GET","./updateusers.php",true);
			userReq.send(null);
			userReq.onreadystatechange=displayUsers;
		}
	}
	
	function displayMessages() {
		getElement("messages").innerHTML=recReq.responseText;
	}
	
	function displayUsers() {
		getElement("userList").innerHTML=userReq.responseText;
	}
	
	function getCaretPos(textElement) {
		var caretPos = 0;
		if (document.selection) {
			textElement.focus();
			var eSel = document.selection.createRange();
			eSel.moveStart('character', -textElement.value.length);
			caretPos = eSel.text.length;
		} else if (textElement.selectionStart || textElement.selectionStart == '0') {
			caretPos = textElement.selectionStart;
		}
		
		return caretPos;
	}
	
	function insertIcon(iconText) {
		var msgBox = getElement("messageBox");
		var msgBoxValue = msgBox.value;
		var caretPos = getCaretPos(msgBox);
		msgBox.value = msgBoxValue.substr(0, caretPos) + " " + iconText + " " +
			msgBoxValue.substr(caretPos);
		msgBox.focus();
	}
	
	function stripHTMLFromMessage() {
		var msgBoxValue = getElement("messageBox").value;
		return msgBoxValue.replace(/(<([^>]+)>)/ig,"");
	}
</script>
</head>
<body onLoad="init(); setInterval(getMessages,2500); setInterval(updateUsers,2500);">
<div id="container">
<h1 id="welcome">Welcome to Amy Chat!</h1>
<p>Amy Chat is a specially developed application for my wife Amy so she can chat 
freely to her workmates and friends from our Wii's Web browser at home.  There's 
nothing complicated to it - just enter you name in the box on below, choose a 
colour from the drop down list and then start typing messages to your friends.</p>
<div align="center">
<label class="userDetail">Your Name:</label>
<input id="userName" class="userField" type="text" title="Enter your name or nickname here."/>
<label class="userDetail">Your Colour:</label>
<select id="colourBox" class="userField" title="Choose a colour to make your comments stand out.">
	<option value="0" style="background: red; color: white;">Red</option>
	<option value="1" style="background: lime; color: black;">Green</option>
	<option value="2" style="background: blue; color: white;">Blue</option>
	<option value="3" style="background: yellow; color: black;">Yellow</option>
	<option value="4" style="background: aqua; color: black;">Aquq</option>
	<option value="5" style="background: fuchsia; color: white;">Fuchsia</option>
	<option value="6" style="background: navy; color: white;">Navy</option>
	<option value="7" style="background: purple; color: white;">Purple</option>
	<option value="8" style="background: maroon; color: white;">Maroon</option>
	<option value="9" style="background: green; color: white;">Dark Green</option>
	<option value="10" style="background: olive; color: white;">Olive</option>
	<option value="11" style="background: chocolate; color: white;">Chocolate</option>
	<option value="12" style="background: deeppink; color: white;">Deep Pink</option>
	<option value="13" style="background: darkorange; color: white;">Orange</option>
	<option value="14" style="background: dodgerblue; color: black;">Sky Blue</option>
	<option value="15"style="background: gold; color: black;">Gold</option>
	<option value="16" style="background: lightseagreen; color: black;">Sea Green</option>
	<option value="17" style="background: firebrick; color: white;">Fired Brick</option>
	<option value="18" style="background: peachpuff; color: black;">Peach Puff</option>
	<option value="19" style="background: springgreen; color: black;">Spring Green</option>
</select>
</div>
<p id="warning">A FEW WORDS OF WARNING!  This is a public site so these messages 
can be viewed by anyone.  Try to keep things in-offensive and DO NOT post 
anything here like credit card details, addresses or telephone numbers that can 
be linked to you or anyone you know!</p>
<h1 id="messagesHeader">Messages</h1>
<div id="messages">

</div>
<h1 id="messageBoxHeader">Your Message:</h1>
<textarea id="messageBox" name="messageBox" title="Enter your message here, click 
the 'Send Message' button to send it."></textarea>
<div id="smiliesBox" title="Click on an icon to add it to your message.">
<img src="./smile.png" title="Smiling" onClick="insertIcon(':)')">
<img src="./laugh.png" title="Laughing" onClick="insertIcon(':D')">
<img src="./lmao.png" title="Laughing My Ass Off" onClick="insertIcon('XD')">
<img src="./sad.png" title="Sad" onClick="insertIcon(':(')">
<img src="./notsure.png" title="Not Sure / Not Well" onClick="insertIcon(':S')"><br>
<img src="./thinking.png" title="Angry / Thinking" onClick="insertIcon('B(')">
<img src="./shifty.png" title="Shifty" onClick="insertIcon('|)')">
<img src="./winking.png" title="Winking" onClick="insertIcon(';)')">
<img src="./surprise.png" titled="Surprised" onClik="insertIcon('8o')">
<img src="./rasp.png" title="Rasping" onClick="insertIcon(':P')"><br>
<img src="./love.png" title="Love Heart" onClick="insertIcon('<B')">
<img src="./egg.png" title="(Easter) Egg" onClick="insertIcon('{}')">
</div>
<button id="submitButton" title="Send the message by clicking this button."
	onclick="sendMessage()">Send Message</button>
</form>
<div id="userList">The are no users online.</div>
<div style="text-align: center">This site is &copy;2009 
<a href="http://www.mevanspn.co.uk">Morgan Evans</a></div>
</div>
</body>
</html>
