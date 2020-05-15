$(document).ready(function(){
    $(".up").on('click',function(){
        var id = $(this).attr("data-code");
        $( "#up"+id).submit();
    });

    $(".down").on('click',function(){
        var id = $(this).attr("data-code");
        $( "#down"+id).submit();
     });

     $(".del").on('click',function(){
         var id = $(this).attr("data-id");
         $( "#del"+id).submit();
     });

})