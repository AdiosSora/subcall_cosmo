window.onload = function() {
  function golink(){
     location.href="login.php";
  }
  function room_in(){
     location.href="room_in.php";
  }
  function room_make(){
  	const p2 = document.getElementById("roommake");

  	if(p2.style.display=="block"){
  		// hiddenで非表示
  		p2.style.display ="none";
  	}else{
  		// visibleで表示
  		p2.style.display ="block";
  	}
  }
}
