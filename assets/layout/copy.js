document.querySelectorAll('img[data-row-id]').forEach(function(btn){
    btn.addEventListener('click',function(){
        let element = document.getElementById(btn.getAttribute('data-row-id'));
        element.select();
        document.execCommand("copy");
    });
})

