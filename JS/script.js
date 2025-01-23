document.addEventListener('DOMContentLoaded', () => {

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openModal(id, event) {
        if (event) {
            event.preventDefault();
        }
        document.getElementById(id).classList.remove('hidden');
    }

    // category
    const addCategory = document.getElementById('add');
    if (addCategory) {
        addCategory.addEventListener('click', (event) => openModal('add_cat', event));
    }

    const closeCategory = document.getElementById('closeModal');
    if (closeCategory) {
        closeCategory.addEventListener('click', () => closeModal('add_cat'));
    }

    const cancelCategory = document.getElementById('cancel');
    if (cancelCategory) {
        cancelCategory.addEventListener('click', () => closeModal('add_cat'));
    }

    const modalCategory = document.getElementById('add_cat');
    if (modalCategory) {
        modalCategory.addEventListener('click', (event) => {
            if (event.target === modalCategory) {
                closeModal('add_cat');
            }
        });
    }

    // menu burger
    document.getElementById('menuToggle').addEventListener('click', function() {
        const navContent = document.getElementById('navContent');
        navContent.classList.toggle('hidden');
    });

    // cours
    const addCours = document.getElementById('add');
    if (addCours) {
        addCours.addEventListener('click', (event) => openModal('add_course_modal', event));
    }

    const closeCours = document.getElementById('closeModal');
    if (closeCours) {
        closeCours.addEventListener('click', () => closeModal('add_course_modal'));
    }

    const cancelCours = document.getElementById('cancel');
    if (cancelCours) {
        cancelCours.addEventListener('click', () => closeModal('add_course_modal'));
    }

    const modalCours = document.getElementById('add_course_modal');
    if (modalCours) {
        modalCours.addEventListener('click', (event) => {
            if (event.target === modalCours) {
                closeModal('add_course_modal');
            }
        });
    }

});