const replace='http://127.0.0.1:8000/img/no-image.jpg';
$("img").each(function (index, value) {
    if(!$(this).attr('src')){
       $(this).attr('src',replace);
    }else{
        let value=$(this).attr('src');
        let ext = value.substring(value.length-4,value.length);
        if(ext[0]!=='.'){
            $(this).attr('src',replace);
        }
    }
});