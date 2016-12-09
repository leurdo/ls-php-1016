$('#btn').on('click', function(){
    $.ajax({
        url: 'get.php',
        data: {
            id: $('#id').val()
        },
        error:function (xhr, ajaxOptions, thrownError){

            $('.result').html(xhr.responseText);
        }
    }).done(function(data){
        var parsed = JSON.parse(data);
        console.log(parsed);
        if (parsed.error) {
            $('tr.result').html(parsed.error);
        } else {

            $('tr.result').html(makeRow(parsed));
        }
    });
});

function makeRow(data){
    return "<td>"+data.title+"</td><td>"+data.description+"</td><td>"+data.price+"</td><td>"+data.categories+"</td>";
}