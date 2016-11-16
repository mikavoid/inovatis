$(document).ready(function(){
    $(document).foundation();
    var elem = new Foundation.AccordionMenu($('#menu'), {});
   // var main_menu = new Foundation.ResponsiveToggle($('#example-menu'), {});

    setTimeout(function() {
        $('.notices').slideUp();
        $('.errors').slideUp();
    }, 4000);


    //Edit product links
    $(document).on('dblclick', 'table.list tbody tr', function(){
        $(location).attr('href', $(this).attr('href'));
    });


});