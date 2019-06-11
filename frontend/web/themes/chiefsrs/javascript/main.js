

var login_btn = document.getElementById("login_btn");
var register_btn = document.getElementById("register_btn");
var login_div = document.getElementById("login");
var register_div = document.getElementById("register");
var login_link = document.getElementById("login_link");
var register_link = document.getElementById("sign_up_link");
var nav = document.getElementById("sticky_nav");
document.onscroll = logScroll;
//document.addEventListener("load", myScript);
myScript();
function myScript() {

    var isLoginActive = login_btn.dataset.active;
    var isRegisterActive = register_btn.dataset.active;
    if (isRegisterActive == "active") {
        login_div.style.display = "none";
        register_div.style.display = "flex";
        register_btn.style.backgroundColor = "#fff";
        register_btn.style.color = "#000";
        login_btn.style.backgroundColor = "#000";
        login_btn.style.color = "#fff";
    }
    else {
        register_div.style.display = "none";
        login_div.style.display = "flex";
        login_btn.style.backgroundColor = "#fff";
        login_btn.style.color = "#000";
        register_btn.style.backgroundColor = "#000";
        register_btn.style.color = "#fff";
    }
}
login_btn.addEventListener("click", function () {
    register_div.style.display = "none";
    login_div.style.display = "flex";
    login_btn.style.backgroundColor = "#fff";
    login_btn.style.color = "#000";
    register_btn.style.backgroundColor = "#000";
    register_btn.style.color = "#fff";
    login_btn.dataset.active = "";
    register_btn.dataset.active = "active";
    
});
register_btn.addEventListener("click", function () {
    login_div.style.display = "none";
    register_div.style.display = "flex";
    register_btn.style.backgroundColor = "#fff";
    register_btn.style.color = "#000";
    login_btn.style.backgroundColor = "#000";
    login_btn.style.color = "#fff";
    
    login_btn.dataset.active = "active";   
    register_btn.dataset.active = "";
});
function logScroll(e) {
    if (window.scrollY > 500) {
        nav.style.display = "flex";
    }else if(window.scrollY < 500){
        nav.style.display = "none";
    }else {
    }
    
    /* if(isScrolledIntoView("section-about")) {
       console.log(document.getSelection());
    } */
}
function isScrolledIntoView(elem) {
    
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
    
    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();
    
    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
var waypoint = new Waypoint({
    element: document.getElementById('first-main-div'),
    handler: function(direction) {
      console.log('Scrolled to waypoint!')
      nav.childNodes[1].childNodes[1].childNodes[0].style.color = "#292929";
      nav.childNodes[1].childNodes[3].childNodes[0].style.color = "#292929";
      nav.childNodes[1].childNodes[5].childNodes[0].style.color = "#292929";
    },
    offset: -20
})
var waypoint = new Waypoint({
    element: document.getElementById('section-about'),
    handler: function(direction) {
      console.log('Scrolled to waypoint!')
      nav.childNodes[1].childNodes[1].childNodes[0].style.color = "#292929";
      nav.childNodes[1].childNodes[3].childNodes[0].style.color = "gold";
      nav.childNodes[1].childNodes[5].childNodes[0].style.color = "#292929";
    },
    offset: -20
})
var waypoint = new Waypoint({
    element: document.getElementById('section-contact'),
    handler: function(direction) {
      console.log('Scrolled to waypoint!')
      nav.childNodes[1].childNodes[1].childNodes[0].style.color = "#292929";
      nav.childNodes[1].childNodes[3].childNodes[0].style.color = "#292929";
      nav.childNodes[1].childNodes[5].childNodes[0].style.color = "gold";
    },
    offset: 0
})
/* var waypoints = $('#section-about').waypoint(function(direction) {
    notify(this.element.id + ' hit 25% from top of window') 
  }, {
    offset: '25%'
})
var waypoints = $('#section-contact').waypoint(function(direction) {
    notify(this.element.id + ' hit 25% from top of window') 
  }, {
    offset: '25%'
}) */