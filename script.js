var dWClass = ["mo","tu","we","th","fr","sa","su"];
var dWAbb = ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
var dWLong = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
window.onload=function(){
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
  //USER & USERSUB
  document.getElementById("user").onmouseover=function(){
    document.getElementById("userSub").style.display = "flex";
  }
  document.getElementById("userSub").onmouseover=function(){
    document.getElementById("userSub").style.display = "flex";
  }
  document.getElementById("user").onmouseout=function(){
    document.getElementById("userSub").style.display = "none";
  }
  document.getElementById("userSub").onmouseout=function(){
    document.getElementById("userSub").style.display = "none";
  }
}
