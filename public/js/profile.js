let userRendered = false;
let currentUserId=null;
let currentTab='miei-post';
let currentPage = 1;
const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');
const loadMore = document.getElementById('load-more');
const postContainer = document.querySelector('.post-container');



    function updateTab(selectedTab) {
        tabLinks.forEach(tab => {
            if (tab.getAttribute('data-tab') === selectedTab) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });
    }

    tabLinks.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            const newTab = this.getAttribute('data-tab');
            
            if (currentTab !== newTab) {
                currentTab = newTab;
                currentPage = 1;
                
                updateTab(currentTab);
                
                postContainer.innerHTML = '';
                retrieve(currentTab, currentPage);
            }
        });
    });

    loadMore.addEventListener('click', function() {
        currentPage++;
        retrieve(currentTab, currentPage);
    });

    function setupDescriptions() {
        const descriptions = document.querySelectorAll('.description-container');
        descriptions.forEach((container, index) => {
            const text = container.querySelector('.description-text');
            const button = container.nextElementSibling;
            
            if (text.scrollHeight > container.clientHeight) {
                button.style.display = 'inline-block';
                button.addEventListener('click', () => toggleDescription(index));
            } else {
                button.style.display = 'none';
            }
        });
    }

    function toggleDescription(postId) {
        const container = document.getElementById(`description${postId}`).parentNode;
        const button = container.nextElementSibling;

        if (container.classList.contains('expanded')) {
            container.classList.remove('expanded');
            button.textContent = 'Leggi descrizione';
        } else {
            container.classList.add('expanded');
            button.textContent = 'Nascondi descrizione';
        }

    }

    function renderUser(user)
    {
        const navbar = document.getElementById('navbarDropdown');
        
        user.forEach(users=>{
            const img=document.createElement("img");
            navbar.appendChild(img);
            img.src=users.immagine_user.path;
            img.className= 'rounded-circle me-2';
        
            const span=document.createElement("span");
            navbar.appendChild(span);
            span.textContent = users.username;
        });   
    }

    function retrieve(tab,page) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
    
            fetch(`/profile/retrieve?tab=${tab}&page=${page}`, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(searchResponse)
        .then(json=>getInfo(json,page));
    }

function getInfo(json,page)
    {
        if (json.user && json.user.length > 0) {
            currentUserId = json.user[0].id; 
        }

        if (!userRendered && json.user) {
            userRendered = true;
            renderUser(json.user);
        }
        else {
            console.log("Utente già renderizzato o mancante");
        }

        if (json.posts) {
            if (page === 1) {
                postContainer.innerHTML = '';
            }
            renderPosts(json.posts,json.immagini);
            if (!json.hasMore) {
                loadMore.style.display = 'none';
            } else {
                loadMore.style.display = 'block';
            }
        }
    }

function renderPosts(posts,immagini) {

    if (!posts || posts.length === 0) {
        renderNoPostsMessage(postContainer);
        return; 
    }

        posts.forEach(post => {
            const postCard = document.createElement('div');
            postCard.className = 'card post-card';
            postCard.setAttribute('data-post-id',post.id);

            //header
            const cardHeader = document.createElement('div');
            cardHeader.className = 'card-header bg-dark d-flex justify-content-between align-items-center';
            cardHeader.id = 'card-header';

            const userInfo = document.createElement('div');
            userInfo.className = 'd-flex align-items-center';
            userInfo.id = 'user-info';

            const userImg = document.createElement('img');
            userImg.src = post.user.immagine_user.path;
            userImg.alt = 'User Profile';
            userImg.className = 'rounded-circle me-2';

            const userLink = document.createElement('a');
            userLink.href = '#';
            userLink.className = 'text-white text-decoration-none';
            userLink.textContent = post.user.username;

            userInfo.appendChild(userImg);
            userInfo.appendChild(userLink);

            const actionsContainer = document.createElement('div');
            actionsContainer.className = 'd-flex align-items-center gap-2';

            // Badge
            const courseBadge = document.createElement('span');
            courseBadge.className = 'badge badge-custom';
            courseBadge.id = 'course-badge';

            const tipoSpan = document.createElement('span');
            tipoSpan.className = 'badge-tipo';
            tipoSpan.textContent = post.tipo;
            tipoSpan.classList.add(post.tipo === 'vendo' ? 'tipo-vendo' : 'tipo-cerco');

            const separator = document.createElement('span');
            separator.textContent = ' | ';

            const corsoSpan = document.createElement('span');
            corsoSpan.className = 'badge-corso';
            corsoSpan.textContent = post.corso.Nome;

            courseBadge.appendChild(tipoSpan);
            courseBadge.appendChild(separator);
            courseBadge.appendChild(corsoSpan);

            cardHeader.appendChild(userInfo);
            cardHeader.appendChild(courseBadge);

            // Card
            const cardBody = document.createElement('div');
            cardBody.className = 'd-flex flex-column';

            const cardContainerBody1 = document.createElement('div');
            cardContainerBody1.className = 'card-body';

            const bookTitle = document.createElement('h5');
            bookTitle.className = 'card-title book-title fw-bold mb-3 text-center';
            bookTitle.textContent = post.titolo;

            cardContainerBody1.appendChild(bookTitle);
            cardBody.appendChild(cardContainerBody1);

            const cardContainerBody2 = document.createElement('div');
            cardContainerBody2.className = 'card-body';

            // Descrizione
            const descriptionContainer = document.createElement('div');
            descriptionContainer.className = 'col-md-8 w-100';

            const descriptionWrapper = document.createElement('div');
            descriptionWrapper.className = 'description-container';

            const description = document.createElement('p');
            description.className = 'card-text description-text mt-4';
            description.id = `description${post.id}`;
            description.textContent = post.descrizione;

            const descriptionOverlay = document.createElement('div');
            descriptionOverlay.className = 'description-overlay';

            const toggleButton = document.createElement('button');
            toggleButton.className = 'btn btn-link p-0 description-toggle';
            toggleButton.id = `toggle${post.id}`;
            toggleButton.textContent = 'Leggi descrizione';

            const detailsContainer = document.createElement('div');
            detailsContainer.className = 'mt-4';

            // Bottone
            const contactButtonDiv = document.createElement('div');
            const contactButton = document.createElement('button');
            contactButton.className = 'btn btn-light mt-auto w-100';


                if (post.tipo === 'vendo') {
                    // Carosello per le immagini
                    const carousel = document.createElement('div');
                    carousel.id = `carouselExampleControls${post.id}`;
                    carousel.className = 'carousel slide';
                    carousel.setAttribute('data-bs-ride', 'carousel');

                    const carouselInner = document.createElement('div');
                    carouselInner.className = 'carousel-inner';

                    post.immagine_post.forEach((immagine, index) => {
                        const carouselItem = document.createElement('div');
                        carouselItem.className = index === 0 ? 'carousel-item active' : 'carousel-item';

                        const bookImage = document.createElement('img');
                        bookImage.src = immagine.path;
                        bookImage.className = 'd-block w-100';
                        bookImage.alt = 'Book Image';
                        bookImage.style.cursor = 'pointer';

                        bookImage.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            showFullscreenImage(bookImage, post.immagine_post);
                        });

                        carouselItem.appendChild(bookImage);
                        carouselInner.appendChild(carouselItem);
                    });

                    carousel.appendChild(carouselInner);

                    if (post.immagine_post.length > 1) {
                        const prevButton = document.createElement('button');
                        prevButton.className = 'carousel-control-prev';
                        prevButton.setAttribute('type', 'button');
                        prevButton.setAttribute('data-bs-target', `#carouselExampleControls${post.id}`);
                        prevButton.setAttribute('data-bs-slide', 'prev');

                        const prevspanButton1 = document.createElement('span');
                        prevspanButton1.className = 'carousel-control-prev-icon';
                        prevspanButton1.setAttribute('aria-hidden', 'true');

                        const prevspanButton2 = document.createElement('span');
                        prevspanButton2.className = 'visually-hidden';
                        prevspanButton2.textContent = 'Previous';

                        prevButton.appendChild(prevspanButton1);
                        prevButton.appendChild(prevspanButton2);

                        const nextButton = document.createElement('button');
                        nextButton.className = 'carousel-control-next';
                        nextButton.setAttribute('type', 'button');
                        nextButton.setAttribute('data-bs-target', `#carouselExampleControls${post.id}`);
                        nextButton.setAttribute('data-bs-slide', 'next');

                        const nextspanButton1 = document.createElement('span');
                        nextspanButton1.className = 'carousel-control-next-icon';
                        nextspanButton1.setAttribute('aria-hidden', 'true');

                        const nextspanButton2 = document.createElement('span');
                        nextspanButton2.className = 'visually-hidden';
                        nextspanButton2.textContent = 'Next';

                        nextButton.appendChild(nextspanButton1);
                        nextButton.appendChild(nextspanButton2);

                        carousel.appendChild(prevButton);
                        carousel.appendChild(nextButton);
                    }

                    cardBody.appendChild(carousel);

                    // Prezzo e condizione
                    const priceConditionDiv = document.createElement('div');

                    const priceP = document.createElement('p');
                    priceP.className = 'mb-2';
                    const priceStrong = document.createElement('strong');
                    priceStrong.textContent = 'Prezzo: € ';
                    const priceSpan = document.createElement('span');
                    priceSpan.className = 'text-success fw-bold';
                    priceSpan.textContent = post.prezzo;
                    priceP.appendChild(priceStrong);
                    priceP.appendChild(priceSpan);

                    const conditionP = document.createElement('p');
                    conditionP.className = 'mb-3';
                    const conditionStrong = document.createElement('strong');
                    conditionStrong.textContent = 'Condizione: ';
                    conditionP.appendChild(conditionStrong);
                    conditionP.appendChild(document.createTextNode(post.condizione));

                    priceConditionDiv.appendChild(priceP);
                    priceConditionDiv.appendChild(conditionP);

                    detailsContainer.appendChild(priceConditionDiv);

                    contactButton.textContent='Contatta Venditore';
                }
                else
                {
                    contactButton.textContent='Contatta Acquirente';
                }
        

            contactButton.onclick = (event) => {
                event.preventDefault();
                event.stopPropagation();
                window.location.href = `/chats/${post.user.username}`;
            };

            descriptionWrapper.appendChild(description);
            descriptionWrapper.appendChild(descriptionOverlay);

            if(post.id_user!=currentUserId)
            {
                contactButtonDiv.appendChild(contactButton);
            }
            
            detailsContainer.appendChild(contactButtonDiv);

            descriptionContainer.appendChild(descriptionWrapper);
            descriptionContainer.appendChild(toggleButton);
            descriptionContainer.appendChild(detailsContainer);
            cardContainerBody2.appendChild(descriptionContainer);

            cardBody.appendChild(cardContainerBody2);

        const icone = {
            Dot: immagini.find(img => img.Nome === 'Dot').path,
            Edit: immagini.find(img => img.Nome==='Edit').path,
            Delete: immagini.find(img => img.Nome=='Delete').path,
            Saved: immagini.find(img => img.Nome==='Saved').path,
            Save: immagini.find(img => img.Nome==='Save').path
        }

        if (post.id_user === currentUserId) {

            const dropdownContainer = document.createElement('div');
            dropdownContainer.className = 'custom-dropdown';

            const dropdownButton = document.createElement('button');
            dropdownButton.className = 'btn btn-link p-0';
            dropdownButton.innerHTML = `<img src="${icone.Dot}" alt="Menu" />`;

            const dropdownMenu = document.createElement('div');
            dropdownMenu.className = 'custom-dropdown-content';

            const editButton = document.createElement('button');
            editButton.className = 'custom-dropdown-item';
            editButton.innerHTML = `<img src="${icone.Edit}" alt="Edit"/> <span>Modifica</span>`;
            editButton.onclick = (event) => {
                event.preventDefault();
                event.stopPropagation();
                editPost(post.id);
            };

            const deleteButton = document.createElement('button');
            deleteButton.className = 'custom-dropdown-item danger';
            deleteButton.innerHTML = `<img src="${icone.Delete}" alt="Delete" class="me-2" /> <span>Elimina</span>`;
            deleteButton.onclick = (event) =>{ event.preventDefault();event.stopPropagation();deletePost(post.id)};

            dropdownMenu.appendChild(editButton);
            dropdownMenu.appendChild(deleteButton);

            dropdownContainer.appendChild(dropdownButton);
            dropdownContainer.appendChild(dropdownMenu);
            actionsContainer.appendChild(dropdownContainer);

            dropdownButton.onclick = (event) => {
                event.preventDefault();
                event.stopPropagation();
                const allDropdowns = document.querySelectorAll('.custom-dropdown-content');
                allDropdowns.forEach(d => {
                    if (d !== dropdownMenu) d.classList.remove('show');
                });
                dropdownMenu.classList.toggle('show');
            };

        }else {
            const favoriteButton = document.createElement('button');
            favoriteButton.className = 'btn btn-link p-0';

            const favorite = parseInt(post.favorite) > 0;
        
            favoriteButton.innerHTML = `<img src="${favorite ? icone.Saved : icone.Save}" alt="Bookmark"/>`;
            favoriteButton.setAttribute('data-post-id', post.id);
            favoriteButton.setAttribute('data-favorited', favorite);

            favoriteButton.onclick = (event) => {
                event.preventDefault();
                event.stopPropagation();
                toggleFavorite(post.id, favoriteButton, icone);
            };
            actionsContainer.appendChild(favoriteButton);
        }
            cardHeader.appendChild(actionsContainer);

            postCard.appendChild(cardHeader);
            postCard.appendChild(cardBody);

            postContainer.appendChild(postCard);            

            setTimeout(() => {
                const descHeight = description.scrollHeight;
                const containerHeight = descriptionContainer.clientHeight;
                const soglia = post.tipo === 'vendo' ? 0.25 : 0.42;
                
                    if (descHeight > containerHeight * soglia) {
                        toggleButton.style.display = 'inline-block';
                        toggleButton.onclick = () => toggleDescription(post.id);
                    } else {
                        toggleButton.style.display = 'none';
                    }
            }, 0);
        });
}


function apriModale() {
    const notification = document.createElement('div');
    notification.className = 'post-success-notification';
    notification.textContent = 'Post pubblicato con successo!';
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 3000);

    cleanModale();

    const modalElement = document.getElementById('createPostModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    modal.hide();
    modalElement.addEventListener('hidden.bs.modal', resetForm);
}

function cleanModale()
{
    resetForm();
    resetError();

    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';

    const postContainer = document.querySelector(".post-container");
    if (postContainer) {
        postContainer.style.overflowY = 'auto';
    }   
}

function resetForm() {
    const form = document.getElementById('createPostForm');
    if (form) {
        form.reset();
        
        const errorElements = form.querySelectorAll('.errore');
        errorElements.forEach(element => {
            element.classList.remove('errore');
        });
        
        const errorSpans = form.querySelectorAll('span.error-message');
        errorSpans.forEach(span => {
            span.textContent = '';
        });
        
        const vendita = document.getElementById('vendita');
        if (vendita) {
            vendita.classList.add('d-none');
        }
        
        const imgInput = document.getElementById("immagini");
        const prezzoInput = document.getElementById("prezzo");
        const condzSelect = document.getElementById("condizione");
        
        if (imgInput) imgInput.removeAttribute('required');
        if (prezzoInput) prezzoInput.removeAttribute('required');
        if (condzSelect) condzSelect.removeAttribute('required');
        
        const methodField = form.querySelector('input[name="_method"]');
        if (methodField) {
            methodField.remove();
        }
        
          resetError();

        form.setAttribute('action', '/posts/store');
        form.setAttribute('method', 'POST');
    }
}

function resetError() {
    const titoloInput = document.querySelector('.titolo input');
    const titoloError = document.querySelector('.titolo span');
    if (titoloInput) {
        titoloInput.classList.remove('errore');
        if (titoloError) titoloError.textContent = '';
    }
    
    const descrizioneTextarea = document.querySelector('.descrizione textarea');
    const descrizioneError = document.querySelector('.descrizione span');
    if (descrizioneTextarea) {
        descrizioneTextarea.classList.remove('errore');
        if (descrizioneError) descrizioneError.textContent = '';
    }
    
    const immaginiInput = document.querySelector('.immagini input');
    const immaginiError = document.querySelector('.immagini span');
    if (immaginiInput) {
        immaginiInput.classList.remove('errore');
        if (immaginiError) immaginiError.textContent = '';
    }
    
    const prezzoInput = document.querySelector('.prezzo input');
    const prezzoError = document.querySelector('.prezzo span');
    if (prezzoInput) {
        prezzoInput.classList.remove('errore');
        if (prezzoError) prezzoError.textContent = '';
    }
}

function modale()
{
    const createPostForm = document.getElementById('createPostForm');
    if (createPostForm) {
        createPostForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const token = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch(this.action, {method: 'POST',body: formData,headers: {'X-CSRF-TOKEN': token}}).then(searchResponse).then(apriModale)
        }
    )}
}

function showDepartment(json)
{
    const Selectcorso=document.querySelector('select[name="id_corso"]');
    
    for(const result of json)
    {
        const option=document.createElement('option');
        option.value=result.id;
        option.textContent=result.Nome;
        Selectcorso.appendChild(option);
    }
}

function checkDepartment()
{
    const token=document.querySelector('meta[name="csrf-token"]').content;
    fetch("/corso",{method:'POST', headers: {'X-CSRF-TOKEN': token,'Accept': 'application/json'}}).then(searchResponse).then(showDepartment);
}


function deletePost(postId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    const confirmButton = document.querySelector('#deleteConfirmModal .btn-danger');
    const handleConfirm = () => {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    
    fetch(`/posts/delete/${postId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(searchResponse)
    .then(json => {
        if (json.success) {
            const postCard = document.querySelector(`[data-post-id="${postId}"]`);
            postCard.classList.add('fade-out');
            setTimeout(() => {
                postCard.remove();
                const remainingPosts = document.querySelectorAll('.post-card');
                if (remainingPosts.length === 0) {
                    renderNoPostsMessage(document.querySelector('.post-container'));
                }
            }, 300);
        }
        modal.hide();
    }) .catch(error => console.error('Error:', error))
    .finally(() => {
        confirmButton.removeEventListener('click', handleConfirm);
    });
};

confirmButton.addEventListener('click', handleConfirm);
modal.show();
}

function showFullscreenImage(clickedImage, Images) {
    const fullscreenContainer = document.createElement('div');
    fullscreenContainer.className = 'fullscreen-image-container';

    const fullscreenImage = document.createElement('img');
    fullscreenImage.src = clickedImage.src;
    fullscreenImage.className = 'fullscreen-image';

    const closeButton = document.createElement('button');
    closeButton.className = 'fullscreen-close';
    closeButton.innerHTML = '&times;';

    fullscreenContainer.appendChild(fullscreenImage);
    fullscreenContainer.appendChild(closeButton);

    if (Images.length > 1) {
        const prevButton = document.createElement('button');
        prevButton.innerHTML = '&#10094;';
        prevButton.className = 'fullscreen-nav prev';
        const nextButton = document.createElement('button');
        nextButton.innerHTML = '&#10095;';
        nextButton.className = 'fullscreen-nav next';

        fullscreenContainer.appendChild(prevButton);
        fullscreenContainer.appendChild(nextButton);

        let current = Images.findIndex(img => img.path === clickedImage.src);

        prevButton.addEventListener('click', () => {
            current = (current - 1 + Images.length) % Images.length;
            fullscreenImage.src = Images[current].path;
        });

        nextButton.addEventListener('click', () => {
            current = (current + 1) % Images.length;
            fullscreenImage.src = Images[current].path;
        });
    }

    document.body.appendChild(fullscreenContainer);

    const closeFullscreen = () => {
        if (document.body.contains(fullscreenContainer)) {
            document.body.removeChild(fullscreenContainer);
        }
    };

    fullscreenContainer.addEventListener('click', (e) => {
        if (e.target === fullscreenContainer) {
            closeFullscreen();
        }
    });
    closeButton.onclick = closeFullscreen;
}

document.addEventListener('DOMContentLoaded', () => {
    const { modalWrapper } = createDeleteConfirmModal();
    document.body.appendChild(modalWrapper);
});

function editPost(post)
{
    fetch(`/posts/edit/${post}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(searchResponse)
    .then(json => {
        if (json.success) {
            const modal = new bootstrap.Modal(document.getElementById('createPostModal'));
            const form = document.getElementById('createPostForm');
            
            form.setAttribute('action', `/posts/update/${post}`);
            form.setAttribute('method', 'POST');
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PUT';
            form.appendChild(methodField);

            document.getElementById('tipo').value = json.post.tipo;
            document.getElementById('titolo').value = json.post.titolo;
            document.getElementById('descrizione').value = json.post.descrizione;
            document.getElementById('id_corso').value = json.post.id_corso;
            
            if (json.post.tipo === 'vendo') {
                document.getElementById('vendita').classList.remove('d-none');
                document.getElementById('condizione').value = json.post.condizione;
                document.getElementById('prezzo').value = json.post.prezzo;
            } else {
                document.getElementById('vendita').classList.add('d-none');
            }

            modal.show();
        }
    })
}

function closeEdit(event)
{
    const dropdowns = document.querySelectorAll('.custom-dropdown-content.show');
    dropdowns.forEach(dropdown => {
        if (!dropdown.contains(event.target) && !dropdown.previousElementSibling.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });
}

document.addEventListener('click',closeEdit);

function updatePost(event)
{
    event.preventDefault();

    const formData = new FormData(this);
    const method = formData.get('_method') || 'POST';
    const url = this.getAttribute('action');

    fetch(url, {
        method: method === 'PUT' ? 'POST' : method,
        body: formData,
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,'X-HTTP-Method-Override': method  
        }
    })
    .then(searchResponse)
    .then(json => {
        if (json.success) {
            bootstrap.Modal.getInstance(document.getElementById('createPostModal')).hide();
            retrieve(currentTab,currentPage); 
        } else {
            Object.keys(json.errors || {}).forEach(key => {
                const element = document.querySelector(`#${key}`);
                if (element) {
                    element.classList.add('is-invalid');
                    const errorDiv = element.parentElement.querySelector('.invalid-feedback') || 
                        document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = json.errors[key][0];
                    element.parentElement.appendChild(errorDiv);
                }
            });
        }
    })
}

document.getElementById('createPostForm').addEventListener('submit',updatePost);

function toggleFavorite(postId,favoriteButton,icone) {

    const token = document.querySelector('meta[name="csrf-token"]').content;
    
    fetch(`post/favorites/${postId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(searchResponse)
    .then(json => {
            const img=favoriteButton.querySelector('img');
            const favorite=json.favorite;
            img.src=favorite ? icone.Saved : icone.Save;
            favoriteButton.setAttribute('data-favorited',favorite);
   });

}

function createDeleteConfirmModal() {
    const modalWrapper = document.createElement('div');
    modalWrapper.className = 'modal fade';
    modalWrapper.id = 'deleteConfirmModal';
    modalWrapper.setAttribute('tabindex', '-1');
    modalWrapper.setAttribute('aria-hidden', 'true');

    const modalDialog = document.createElement('div');
    modalDialog.className = 'modal-dialog modal-dialog-centered';

    const modalContent = document.createElement('div');
    modalContent.className = 'modal-content';

    const modalHeader = document.createElement('div');
    modalHeader.className = 'modal-header';

    const modalTitle = document.createElement('h5');
    modalTitle.className = 'modal-title';
    modalTitle.textContent = 'Conferma eliminazione';

    const closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.className = 'btn-close';
    closeButton.setAttribute('data-bs-dismiss', 'modal');
    closeButton.setAttribute('aria-label', 'Close');

    const modalBody = document.createElement('div');
    modalBody.className = 'modal-body';
    modalBody.textContent = 'Sei sicuro di voler eliminare questo post?';

    const modalFooter = document.createElement('div');
    modalFooter.className = 'modal-footer';

    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.className = 'btn btn-secondary';
    cancelButton.setAttribute('data-bs-dismiss', 'modal');
    cancelButton.textContent = 'Annulla';

    const confirmButton = document.createElement('button');
    confirmButton.type = 'button';
    confirmButton.className = 'btn btn-danger';
    confirmButton.textContent = 'Elimina';

    modalHeader.appendChild(modalTitle);
    modalHeader.appendChild(closeButton);
    modalFooter.appendChild(cancelButton);
    modalFooter.appendChild(confirmButton);

    modalContent.appendChild(modalHeader);
    modalContent.appendChild(modalBody);
    modalContent.appendChild(modalFooter);
    modalDialog.appendChild(modalContent);
    modalWrapper.appendChild(modalDialog);

    return { modalWrapper, confirmButton };
}

function renderNoPostsMessage(postContainer) {
    postContainer.innerHTML = '';
    
    const noPostDiv = document.createElement('div');
    noPostDiv.className = 'text-center mt-5 no-posts-message';
    
    const noPostMessage = document.createElement('h4');
    noPostMessage.textContent = 'Nessun post ancora disponibile';
    
    noPostDiv.appendChild(noPostMessage);
    postContainer.appendChild(noPostDiv);
}

function checkTitle()
{
    const titolo=document.querySelector('.titolo input');
    const errorSpan = document.querySelector('.titolo span');

    if(titolo.value.length < 4)
    {
        errorSpan.textContent = "Inserisci un Titolo più lungo (Almeno 4 caratteri)";
        document.querySelector('.titolo').classList.add('errore');
    }
    else{
        document.querySelector('.titolo').classList.remove('errore');
        errorSpan.textContent = "";
    }
}

function checkDescription() {
    const descrizione = document.querySelector('.descrizione textarea');
    const errorSpan = document.querySelector('.descrizione span');
    
  if(descrizione.value.length < 5){
        errorSpan.textContent = "La descrizione deve essere di almeno 5 caratteri";
        document.querySelector('.descrizione').classList.add('errore');
    }
    else{
        document.querySelector('.descrizione').classList.remove('errore');
        errorSpan.textContent = "";
    }
}


function checkImg() {
    const immagini = document.querySelector('.immagini input');
    const errorSpan = document.querySelector('.immagini span');
    const tipoSelect = document.querySelector('#tipo');

    if(tipoSelect.value === 'vendo') {
        if(immagini.files && immagini.files.length < 0) {
            errorSpan.textContent = "Devi caricare almeno un'immagine";
            document.querySelector('.immagini').classList.add('errore');
        }
        else{
            document.querySelector('.immagini').classList.remove('errore');
            errorSpan.textContent = "";
        }
    }
}

function checkPrezzo() {
    const prezzo = document.querySelector('.prezzo input');
    const errorSpan = document.querySelector('.prezzo span');
    
    if(isNaN(prezzo.value) && prezzo.value.trim() !== '') {
        errorSpan.textContent = "Inserisci un prezzo valido";
        document.querySelector('.prezzo').classList.add('errore');
    }
    else
    {
        document.querySelector('.prezzo').classList.remove('errore');
        errorSpan.textContent = "";
    }
}

function VendoCerco()
{
    const tipo = document.getElementById('tipo').value;
    const vendita = document.getElementById('vendita');
    const imgInput = document.getElementById("immagini");
    const prezzoInput = document.getElementById("prezzo");
    const condzSelect = document.getElementById("condizione");
        
    if(tipo==="Vendo" || tipo==='vendo') 
    {
        vendita.classList.remove("d-none");
    } else {
        vendita.classList.add("d-none");
        imgInput.removeAttribute('required');
        prezzoInput.removeAttribute('required');
        condzSelect.removeAttribute('required');
    }
}

function searchResponse(response)
{
    return response.json();
}

const logoutButton=document.getElementById('logout');
logoutButton.onclick = (e) => {
    e.preventDefault();
    window.location.href="/logout";
}

window.onload=function()
{
    retrieve(currentTab, currentPage);
    updateTab(currentTab);
    checkDepartment();
}

document.querySelector('.titolo input').addEventListener('blur', checkTitle);
document.querySelector('.descrizione textarea').addEventListener('blur', checkDescription);
document.querySelector('.immagini input').addEventListener('blur', checkImg);
document.querySelector('.prezzo input').addEventListener('blur', checkPrezzo);
document.getElementById('createPostModal').addEventListener('hidden.bs.modal', cleanModale);
