// Handles dragging and dropping the admin bar in the frontend view

{
  var adminbar = document.getElementById("wpadminbar");
  var drag = document.getElementById("wp-admin-bar-drag");
  var startx;
  var starty;
  var currentx = 0;
  var currenty = 0;
  var isDragging = false;

  function setTransform(x, y) {
    adminbar.style.setProperty("--dx", x + "px");
    adminbar.style.setProperty("--dy", y + "px");
  }

  drag.addEventListener("mousedown", (e) => {
    startx = e.clientX - currentx;
    starty = e.clientY - currenty;
    isDragging = true;
  }, false);

  drag.addEventListener("mousemove", (e) => {
    if (isDragging === true) {
      setTransform(e.clientX - startx, e.clientY - starty);
      currentx = e.clientX - startx;
      currenty = e.clientY - starty;
    }
  }, false);

  drag.addEventListener("mouseup", (e) => {
    isDragging = false;
    setTransform(e.clientX - startx, e.clientY - starty);
  }, false);

}
