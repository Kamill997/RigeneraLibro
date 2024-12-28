function pick(json)
{
    const photo=document.querySelector(".pick");
    
    json.forEach(function(result)
    {
      if(result.Tipo==='Auth')
      {
        if(result.Nome==='LoginBack')
            photo.style.backgroundImage='url('+result.path+')';
      }
    });
}

function searchResponse(response)
{
    return response.json();
}

function photo()
{
    const token=document.querySelector('meta[name="csrf-token"]').content;
    fetch("/login/photo",{method:'POST', headers: {'X-CSRF-TOKEN': token,'Accept': 'application/json'}}).then(searchResponse).then(pick);
}

function showPassword()
{
    const togglePassword = document.getElementById('showPassword');
    const password = document.getElementById('password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
}

window.onload=function()
{
    photo();
    showPassword();
}
