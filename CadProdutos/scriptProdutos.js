document.addEventListener('DOMContentLoaded', function () {
    const toggler = document.getElementById('navbar-toggler');
    const collapse = document.getElementById('navbar-collapse');

    toggler.addEventListener('click', function () {
        if (collapse.style.display === 'block') {
            collapse.style.display = 'none';
        } else {
            collapse.style.display = 'block';
        }
    });
});
