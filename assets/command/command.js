addEventListenersToDeleteBtn = function(){
    document.querySelectorAll('div[data-delete-command-url]').forEach(function(el) {
        el.addEventListener('click', function(evt) {
            evt.preventDefault();
            location.reload();
            fetch(el.getAttribute('data-delete-command-url'),{
                method: `DELETE`,
            })
                .then(response => {
                    if(response.status === 200){
                        alert('Command deleted!');
                    } else {
                        alert('An error has occurred');
                    }
                })
        })
    });
}

document.addEventListener('DOMContentLoaded', function() {
    addEventListenersToDeleteBtn();
})
