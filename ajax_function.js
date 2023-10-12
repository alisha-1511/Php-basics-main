$(document).on('change','#country',function(){
    var cid =  $('#country').val();
    $.ajax({
                url:"state.php",
                method:'POST',
                dataType: 'html',
                data:{counid : cid},
                success:function(res)
                {   //console.log(data);
                    $("#state").html(res);
                   
                }
            });
})