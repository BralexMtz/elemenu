let mainNav = document.getElementById("js-menu");
let navBarToggle = document.getElementById("js-navbar-toggle");

if( mainNav!=null && navBarToggle!=null ){
  navBarToggle.addEventListener("click", function() {
    mainNav.classList.toggle("active");
  });
}