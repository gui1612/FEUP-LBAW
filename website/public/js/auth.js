

function showHidden() {
  var x = document.getElementsByClassName(".password");
  if(x.type === "password") {
    x.type = "text";
  }
  else {
    x.type = "password";
  }
}