document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    form.addEventListener('submit', (event) => {
        event.preventDefault();
                
        const formData = new FormData(event.target);
        const formDataObj = Object.fromEntries(formData.entries());

        console.log('Form data:', formDataObj);

        fetch('/login-be', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formDataObj)
        })
        .then(async response => {
            if (!response.ok) {
                const errors = await response.json();
                throw new Error(JSON.stringify(errors));
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if(data.status === "true"){
                window.location.href='/';
            }else{
                const errors = document.querySelectorAll('.error');
                errors.forEach(error=>{
                    error.innerText = '';
                })

                let parent = document.getElementById('error-creds');
                if(data.status === "emailUsr"){
                    parent = document.getElementById('error-user');
                }else if(data.status === "password"){
                    parent = document.getElementById('error-pw');
                }
                parent.innerText = data.msg;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
