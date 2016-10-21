$(document).ready(function(){
    $(document).foundation();
    var elem = new Foundation.AccordionMenu($('#menu'), {});
   // var main_menu = new Foundation.ResponsiveToggle($('#example-menu'), {});

    setTimeout(function() {
        $('.notices').slideUp();
        $('.errors').slideUp();
    }, 4000);


    //Edit product links
    $('table.list tbody tr').dblclick(function() {
       $(location).attr('href', $(this).attr('href'));
    });

});