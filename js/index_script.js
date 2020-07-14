
  //初期表示は非表示
document.getElementById("room_create_form").style.display="none";
function clickBtn_create(){
  const p1 = document.getElementById("room_create_form");

  if(p1.style.display=="block"){
    // noneで非表示
    p1.style.display ="none";
  }else{
    // blockで表示
    p1.style.display ="block";
  }
}
