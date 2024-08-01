$(function(){
    function load_intro_rodada()
    {
        const loader = "<div class='d-flex justify-content-center' style='width:100%;height:100%;'>\
        <div class='spinner-border align-self-center' style='width: 7rem; height: 7rem;' role='status'>\
            <span class='sr-only'>Loading...</span>\
        </div>\
    </div>";

        let id = "{{$id_rodada}}";
        $("#intro-rodada").empty();
        $("#intro-rodada").append(loader);
        $.ajax({
            url: '/load_intro_rodada',
            type: 'get',
            data: {
                'id_rodada': id
            },
            success:function(response){

            },
            error:function(error){

            }

        });
    }
});