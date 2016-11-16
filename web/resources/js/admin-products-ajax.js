//functions
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$(document).ready(function(){
  $(document).on('click', '.check', function() {
    var product_id = $(this).data('id');
    var bool_name = $(this).data('bool_name').toLowerCase();

    //Protections
    bool_name = encodeURI(bool_name);
    product_id = parseInt(product_id);

    $.ajax({
      url: Routing.generate('admin.ajaxSetBool'),
      type: "POST",
      data: {
        product_id : product_id,
        checked : $(this).prop('checked'),
        bool_name : bool_name
      },
      dataType : "json",
      success: function(data) {
        //var route = Routing.generate('admin_event_edit', {id : id});
        //window.location.href = route;
      },
      error: function () {
        alert('Error');
      }
    });
  });
  $('#search_input').keydown(function (){
    if ($('#search_input').val().length > 2) {
      delay(function() {
        var search_terms = $('#search_input').val();
        $.ajax({
          url: Routing.generate('admin.ajaxSearch'),
          type: "POST",
          data: {
            search_terms: encodeURI(search_terms)
          },
          dataType: "html",
          beforeSend : function() {
            $('#products_list').html('');
            $('#spinner').fadeIn(250);
          },
          success: function (data) {
            $('#spinner').fadeOut(250);
            $('#products_list').html(data);
          },
          error: function () {
            alert('Error');
          }
        });
      }, 500);

    }
  })
});