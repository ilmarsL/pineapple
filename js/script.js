const form = document.getElementById('subscribe-form');
const errorBox = document.getElementById('error-message');
const emailInput = document.getElementById('email-input');
const submitButton = document.querySelector('#subscribe-form input[type=submit]');
const agreeCheckbox = document.getElementById('tos'); 

emailInput.addEventListener('input', validate);

//in case checkbox gets unchecked after entering e-mail
agreeCheckbox.addEventListener('change', validate);

submitButton.addEventListener('click', validate);

form.addEventListener('submit', (e)=>{
    e.preventDefault();
    //send request manually
    let myFormData = new FormData(e.target);
    myFormData.append('javaScriptEnabled', 'true');
    fetch('/index.php', {
        method: 'POST',
        body: myFormData,
        headers: new Headers()
    })
    .then(response => response.text())
    .then((data) =>
    {
        console.log('data');
        console.log(data);
        if (data == 'save_success'){
            document.querySelector('main h1').textContent = 'Thanks for subscribing!';
            document.querySelector('main p').textContent = 'You have successfully subscribed to our email listing. Check your email for the discount code.';
            document.querySelector('main .trophy').removeAttribute('hidden');
            document.querySelector('form').style.display = 'none';
        }
        else{
            console.log('Error saving to databse');
            emailInput.setCustomValidity(data);
            emailInput.reportValidity();
        }
    })
    .catch((error) =>{
        console.log('Error');
    });

});

function validate(e){
    submitButton.disabled = false;
    emailInput.setCustomValidity('');
    if (emailInput.validity.valueMissing){
        emailInput.setCustomValidity('Email address is required');
    }
    else if(emailInput.validity.typeMismatch){
        emailInput.setCustomValidity('Please provide a valid e-mail address');
    }
    else if(agreeCheckbox.checked === false){
        emailInput.setCustomValidity('You must accept the terms and conditions');
    }
    else if(emailInput.value.endsWith('.co')){
        emailInput.setCustomValidity('We are not accepting subscriptions from Colombia emails');
    }

    if(!emailInput.reportValidity()){
        //invalid input
        e.preventDefault();
        submitButton.disabled = true;
    }
    else{
        //all is good, submit and show conformation message
        submitButton.disabled = false;
    }
}