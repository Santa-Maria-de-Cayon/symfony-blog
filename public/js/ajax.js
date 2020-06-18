//function megusta(id){
//
//   // alert(id);
//    let ruta = Routing.generate('likes');
//
//    $.ajax({
//       type    : 'POST',
//       url     : ruta,
//       data    : ({id: id}),
//       async   : true,
//       dataType: 'json',
//       success : function(data){
//           alert(data);
//       }
//    });
//};


jQuery(document).ready(function($){
    console.log('click');

    $('#custom_likes').click(function(){

        let ruta = Routing.generate('likes');
        let custom_action = $(this).data('action');

        $.ajax({
            type: 'POST',
            url:  ruta,
            data: { id  : custom_action },

            success : function(x){
                console.log(x);
                $('#response').html('<div class="tegusto">Te gusto este post</div>');
                },
            error : function(error){
                console.log(error);
            }
        });
    });
});