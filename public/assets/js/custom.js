(function($) {
    $(document).on("change", "select.state_number", function(){ show_city(this); });
    
  // modal show 
  function show_city(e){
    var nrc_id = $(e).val();
    $("#login").modal("show");
    $(".hideLink").html("<input type='hidden' name='link' value="+link+">");
  }

  
});