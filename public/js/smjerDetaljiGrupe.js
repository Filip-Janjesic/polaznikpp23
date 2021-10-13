$( '.nazivi' ).mouseenter(function() {
    let element = $(this);
    let id = element.attr('id').split('_')[1];
    $.ajax({
        type:'POST',
        url:'/smjer/grupe',
        data:{
            smjer: id
        },
        success: function(odgovor){
           element.attr('title',odgovor);
        }
    });

  });