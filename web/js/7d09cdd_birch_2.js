$(document).ready(function(e) {

    $('#main-navbar ul li a').bind('click', function(e) {
         // prevent default anchor click behavior
       e.preventDefault();

       // animate
       $('html, body').animate({
           scrollTop: $(this.hash).offset().top - 47
         }, 400, function(){

           // when done, add hash to url
           // (default click behaviour)
           window.location.hash = this.hash;
         });
    });
});