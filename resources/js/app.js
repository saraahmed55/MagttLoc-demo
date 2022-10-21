require('./bootstrap');
// setTimeout(function() {
//     $('.alert').hide();
//     }, 3000);
$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});


