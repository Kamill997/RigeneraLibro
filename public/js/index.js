function ImgInte(json)
{
    const background=document.getElementById('hero-video');
    const logo = document.querySelector('.navbar-brand');
    const leftimg=document.querySelector('[data-aos="fade-right"]');

    json.forEach(function(images)
{
    if(images.Tipo==='Home')
    {
        if(images.Nome==='Landing')
        {
            const video=document.createElement('source');
            video.src=images.path;
            video.type="video/mp4";
            background.appendChild(video);
        }
        if(images.Nome==='Promo1')
        {
          
            const img=document.createElement('img');
            img.src=images.path;
            img.alt="Come Funziona";
            img.className="img-fluid rounded shadow";
            leftimg.appendChild(img);
        }
    }
    else if(images.Tipo==='Background')
    {
        if(images.Nome==='Logo')
        {
            const span=document.createElement("span");
            span.className="site-name";
            span.textContent="RigeneraLibro";

            const img=document.createElement('img');
            img.src=images.path;
            img.alt="RigeneraLibro";
            img.style="height:30;";
            logo.appendChild(img);
            logo.appendChild(span);
        }
    }

})
}

function contact(json)
{
    const responseMessage = document.getElementById('Message');
    const div=document.createElement("div");
    div.className="alert alert-success"; 
    div.textContent=json.success;
    responseMessage.appendChild(div);

    
    setTimeout(() => {
         div.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        div.classList.remove('show');
        setTimeout(() => {
            div.remove();
        }, 500);
    }, 2000);
}

function contactUs(event)
{
    event.preventDefault();
    const token=document.querySelector('meta[name="csrf-token"]').content;
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();

    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('message', message);

    fetch("/home/contact",{method:'POST',headers:{'X-CSRF-TOKEN': token,'Accept': 'application/json'},body: formData}).then(searchResponse).then(contact);

    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('message').value = '';
}

const form = document.getElementById('contact');
form.addEventListener("submit",contactUs);

function searchResponse(response)
{
    return response.json();
}

function showGallery()
{
    const token=document.querySelector('meta[name="csrf-token"]').content;
    fetch("home/photo",{method:'POST', headers: {'X-CSRF-TOKEN': token,'Accept': 'application/json'}}).then(searchResponse).then(ImgInte);
}

function TextArea() {
    const textarea = document.querySelector('textarea');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
}

function stats() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const targetValue = Math.floor(Math.random() * (1000 - 500) + 250);
        counter.setAttribute('data-target', targetValue);

        const updateStats = () => {
            const value = +counter.innerText;
            const target = +counter.getAttribute('data-target');
            const increment = target / 200;

            if (value < target) {
                counter.innerText = Math.ceil(value + increment);
                setTimeout(updateStats, 1);
            } else {
                counter.innerText = target;
            }
        };

        updateStats();
    });
}

function initializeAOS() {
    AOS.init({
        duration: 1000,
        once: true
    });
}
function NavEffects() {
    const navbar = document.querySelector('.navbar');
    const heroSection = document.querySelector('.hero-section');
    const sidebtn = document.querySelector('.side-btn');

    function updateNavbarsideButton() {
        if (!heroSection) return;
        
        const heroBottom = heroSection.offsetTop + heroSection.offsetHeight;
        if (window.scrollY >= heroBottom) {
            navbar.classList.add('visible');
            sidebtn.classList.add('visible');
        } else {
            navbar.classList.remove('visible');
            sidebtn.classList.remove('visible');
        }
    }

    window.addEventListener('scroll', updateNavbarsideButton);
    updateNavbarsideButton(); 
}

function Scroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const element = document.querySelector(this.getAttribute('href'));
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
}

window.onload=function()
{
    setTimeout(() => {
        TextArea();
        stats();
        initializeAOS();
        NavEffects();
        Scroll();
        showGallery();
    },100);
}