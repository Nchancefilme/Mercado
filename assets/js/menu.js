//portal
let menu = document.getElementById("menu");
let open_menu = document.getElementById("open-menu");
let close_menu = document.getElementById("close-menu");
let close = document.getElementById("close");

open_menu.addEventListener('click', function (event) {
    event.preventDefault();
    this.style.display = "none";
    menu.style.display = "block";
    close_menu.style.display = "block";
    close.style.display = "block";
})

close_menu.addEventListener('click', function (event) {
    event.preventDefault();
    this.style.display = "none";
    menu.style.display = "none";
    close.style.display = "none";
    open_menu.style.display = "block";
})