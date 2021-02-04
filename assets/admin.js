import './scss/admin.scss';

document.addEventListener('DOMContentLoaded', function() {

    const iconSelectButtons = document.querySelectorAll('.icon_select_button');
    const iconSelectInput = document.querySelector('#knowledge_icon');
    const iconSelectInputImg = document.querySelector('#knowledge_icon_img');

    iconSelectButtons.forEach(element => {
        element.addEventListener('click', function(e) {
            iconSelectInput.value = e.currentTarget.children[0].alt;
            iconSelectInputImg.src = iconSelectInputImg.src.substr(0, iconSelectInputImg.src.lastIndexOf('/') + 1) + e.currentTarget.children[0].alt;
        });
    });

});