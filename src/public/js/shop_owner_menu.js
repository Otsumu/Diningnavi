document.addEventListener('DOMContentLoaded', function () {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            const subList = this.nextElementSibling;

            console.log('Dropdown clicked'); 

            if (subList) {
                subList.classList.toggle('hidden');
                console.log('Sublist visibility:', !subList.classList.contains('hidden'));
            }
        });
    });
});