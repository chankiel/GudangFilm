document.addEventListener('DOMContentLoaded',()=>{
    const modal = document.getElementById('succ-modal');
    const closeBtn = document.getElementById('closeBtn');
    const main = document.getElementById('main-content');

    if(modal){
        closeBtn.onclick = ()=>{
            modal.classList.add('hidden');
            main.classList.remove('blur-sm');
        }

        window.onclick = function(event){
            if(event.target === modal){
                modal.classList.add('hidden');
                main.classList.remove('blur-sm');
            }
        }
    }
})