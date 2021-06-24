console.log('loading script cart.js');

jQuery(function($) {
    jQuery(".btn_add").on('click', (e) =>{
        var url = $(e.currentTarget).attr('url');
        
        $(e.currentTarget).attr("disabled", true);

        $.post(url)
            .done((ret)=>{
                console.log(ret);
                alert('Vous avez un nouvel item dans votre panier');
            })
            .fail(()=>{
                alert('KO');
            })
            .always((ret)=>{
                $(e.currentTarget).prop("disabled", false);
            })
    });
});