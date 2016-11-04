var dWClass = ["mo","tu","we","th","fr","sa","su"];
var dWAbb = ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
var dWLong = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
function onres(){
  if (window.innerWidth < 600) {
    for (var i = 0; i<7; i++){
      document.getElementById(dWClass[i]).innerHTML=dWAbb[i];
    }
  } else {
    for (var j = 0; j<7; j++){
      document.getElementById(dWClass[j]).innerHTML=dWLong[j];
    }
  }
}
window.onresize=function(){
  onres();
}
window.onload=function(){
  onres();
  document.getElementById("add").onmouseover=function(){
    document.getElementById("addSub").style.display = "flex";
  }
  document.getElementById("addSub").onmouseover=function(){
    document.getElementById("addSub").style.display = "flex";
  }
  document.getElementById("add").onmouseout=function(){
    document.getElementById("addSub").style.display = "none";
  }
  document.getElementById("addSub").onmouseout=function(){
    document.getElementById("addSub").style.display = "none";
  }
}
