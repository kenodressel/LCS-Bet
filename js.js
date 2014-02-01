// JavaScript Document
function tipp(gameid,teamid,team2id,aktiv,tippid,uid) {
	//is the user logged in?
	if(uid == -1) {
		alert("Zum Tippen bitte einloggen");
	} else { //Do the tipp
		var ajaxEl = new XMLHttpRequest();
		var iddiv = gameid + "." + teamid;
		var iddiv2 = gameid + "." + team2id;
		var div = document.getElementById(iddiv);
		var div2 = document.getElementById(iddiv2);
		ajaxEl.onreadystatechange = function(){
			if(ajaxEl.readyState == 4 && ajaxEl.status == 200) { //wait till ajax is finished 
				if(aktiv == 0) { //just do something if the tip is not selected
					//set the current team as the tip
					div.classList.add("derTipp");
					div.setAttribute("onclick","tipp("+gameid+","+teamid+","+team2id+",1,"+ajaxEl.responseText+","+uid+")");
					
					//set the opposing team to not the tip
					div2.classList.remove("derTipp");
					div2.setAttribute("onclick","tipp("+gameid+","+team2id+","+teamid+",0,"+ajaxEl.responseText+","+uid+")");
				}
			}
		};
		//send ajax
		ajaxEl.open('GET', 'ajax.php?fn=tipp&spiel='+gameid+'&team='+teamid+'&uid='+uid+'&tid='+tippid, true);
		ajaxEl.send();
	}
}
function win(gameid,teamid,team2id,aktiv) {
	//site can only be access by the admin, no userid required
	var ajaxEl = new XMLHttpRequest();
	var iddiv = gameid + "." + teamid;
	var iddiv2 = gameid + "." + team2id;
	var div = document.getElementById(iddiv);
	var div2 = document.getElementById(iddiv2);
	ajaxEl.onreadystatechange = function(){
		if(ajaxEl.readyState == 4 && ajaxEl.status == 200) { //wait till ajax is finished
			if(aktiv == 0) {
				div.classList.add("derTipp");
				div.setAttribute("onclick","win("+gameid+","+teamid+","+team2id+",1)");
				
				div2.classList.remove("derTipp");
				div2.setAttribute("onclick","win("+gameid+","+team2id+","+teamid+",0)");
			}
		}
	};
	//send ajax
	ajaxEl.open('GET', 'ajax.php?fn=win&spiel='+gameid+'&team='+teamid, true);
	ajaxEl.send();
}