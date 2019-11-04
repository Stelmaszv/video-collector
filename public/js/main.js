const replace='http://127.0.0.1:8000/img/no-image.jpg';
$("img").each(function (index, value) {
    let src=$(this).attr('src')
    var ext = src.substr(src.lastIndexOf('.') + 1);
    if(ext && ext[0]==='/'){
        $(this).attr('src',replace);
    }
});
const limit=30;
let elemnts= document.querySelectorAll('[dolongfilter]')
for(let elemnt of elemnts ){
    if(elemnt.innerHTML.length>limit){
        let newvalue='';
        for(let i = 0; i < elemnt.innerHTML.length; i++){
            if(i<limit){
                newvalue+=elemnt.innerHTML[i]
            }
        }
        elemnt.innerHTML=newvalue+=' ...'
    }
}
let form=$(".formnavbar");
form.on('submit',function(e){
    let search=form.find('.search').val();
    let selectvalue=form.find('select').val();
    if(selectvalue!='All'){
        if(search.length>0){
            form.attr('action','/faind'+selectvalue+'/'+search);
        }else{
            form.attr('action','/show'+selectvalue+'/');
        }
    }else{
        form.attr('action',selectvalue);
    }
})

