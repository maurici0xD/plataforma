var inactivityTime = function () {
  var time;
  window.onload = resetTimer;
  // DOM Events
  document.onmousemove = resetTimer;
  document.onkeypress = resetTimer;
  document.onload = resetTimer; 
 document.onmousedown = resetTimer; // touchscreen presses
 document.ontouchstart = resetTimer;
 document.onclick = resetTimer;     // touchpad clicks
 document.onscroll = resetTimer;    // scrolling with arrow keys


  function logout() {
      //alert("You are now logged out.")
      location.href = '../usr/cerrarsesion.php'
  }

  function resetTimer() {
      clearTimeout(time);
      time = setTimeout(logout, 900000)
      // 1000 milliseconds = 1 second
  }
};