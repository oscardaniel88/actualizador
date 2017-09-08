// JavaScript Document
function CustomAlert(){
  this.render = function(dialog, redirect){
	var winW = window.innerWidth;
	var winH = window.innerHeight;
	var dialogoverlay = document.getElementById('dialogoverlay');
	var dialogbox = document.getElementById('dialogbox');
	dialogoverlay.style.display = "block";
	dialogoverlay.style.height = winH+"px";
	dialogbox.style.left = (winW/2) - (550 * .5)+"px";
	dialogbox.style.top = "100px";
	dialogbox.style.display = "block";

	dialogbox.innerHTML = `<div id='dialogboxhead'><img src='images/favicon.png'></img></div>
				<div id='dialogboxbody'>${dialog}</div>
				<div id='dialogboxfoot'><div class='alertokbtn'><button onclick='Alert.ok("${redirect}")'>OK</button></div></div>`;

	}
	this.ok = function(redirect){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";

		window.location = redirect;
	  }
	}
	var Alert = new CustomAlert();