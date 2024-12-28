function checkName(event) {
    const input = event.currentTarget;
    
    if (input.value.length > 0) 
    {
        input.parentNode.parentNode.classList.remove('errore');
    } 
    else 
    {
        input.parentNode.parentNode.classList.add('errore');
    }
    
}

function ResponseCheckUsername(json) {
    if (!json.exists)
    {
        document.querySelector('.Username').classList.remove('errore');
    } 
    else 
    {
        document.querySelector('.Username span').textContent = "Nome utente già utilizzato";
        document.querySelector('.Username').classList.add('errore');        
    }
}

function ResponseCheckEmail(json) 
{
    if (!json.exists) 
    {
        document.querySelector('.Email').classList.remove('errore');
    } 
    else 
    {
        document.querySelector('.Email span').textContent = "Email già utilizzata";
        document.querySelector('.Email').classList.add('errore');
    }
}

function fetchResponse(response) 
{
    return response.json();
}

function checkUsername() 
{
    const input = document.querySelector('.Username input');
    const username = input.value;

    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) 
    {
        input.parentNode.parentNode.querySelector('span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
        input.parentNode.parentNode.classList.add('errore');
    } 
    else 
    {
        const token=document.querySelector('meta[name="csrf-token"]').content;
        fetch("registration/Username", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username }),
        }).then(fetchResponse).then(ResponseCheckUsername);
    }    
}

function checkEmail() 
{
    const emailInput = document.querySelector('.Email input');
    const email = emailInput.value;
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(emailInput.value).toLowerCase())) 
    {
        document.querySelector('.Email span').textContent = "Email non valida";
        document.querySelector('.Email').classList.add('errore');
    } 
    else 
    {
        const token=document.querySelector('meta[name="csrf-token"]').content;
        fetch("registration/Email", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email }),
        }).then(fetchResponse).then(ResponseCheckEmail);
    }
}

function checkPassword() 
{
    const passwordInput = document.querySelector('.Password input');
    if (passwordInput.value.length >= 8) 
    {
        document.querySelector('.Password').classList.remove('errore');
    } 
    else 
    {
        document.querySelector('.Password span').textContent = "Password debole";
        document.querySelector('.Password').classList.add('errore');
    }
}

function checkCourse()
{
    const token=document.querySelector('meta[name="csrf-token"]').content;
    fetch("/facolta",{method:'POST', headers: {'X-CSRF-TOKEN': token,'Accept': 'application/json'}}).then(searchResponse).then(pickCourse);
}

function pickCourse(json)
{
    const Selectcorso=document.querySelector('select[name="id_facolta"]');

    for(const result of json)
        {
            const option=document.createElement('option');
            option.value=result.id;
            option.textContent=result.Nome;
            Selectcorso.appendChild(option);
        }
}

function pickRegistration(json)
{
    const photo=document.querySelector(".pick");
    
    json.forEach(function(result)
    {
      if(result.Tipo==='Auth')
      {
        if(result.Nome==='RegistrationBack')
            photo.style.backgroundImage='url('+result.path+')';
      }
    });
}

function searchResponse(response)   
{

    return response.json();
}

function photoregistration()
{
    const token=document.querySelector('meta[name="csrf-token"]').content;
    fetch("registration/photo",{method:'POST', headers: {'X-CSRF-TOKEN': token,'Accept': 'application/json'}}).then(searchResponse).then(pickRegistration);
}

window.onload=function()
{
    photoregistration();
    checkCourse();
}

document.querySelector('.Nome input').addEventListener('blur', checkName);
document.querySelector('.Cognome input').addEventListener('blur', checkName);
document.querySelector('.Username input').addEventListener('blur', checkUsername);
document.querySelector('.Email input').addEventListener('blur', checkEmail);
document.querySelector('.Password input').addEventListener('blur', checkPassword);