"use strict";

// Fecha o alerta automaticamente após alguns segundos
const closeAlert = (element) => {
    let delay = 3000;

    if (element.classList.contains('alert-danger') || element.classList.contains('alert-warning')) {
        delay = 5000;
    }

    setTimeout(() => {
        element.classList.remove('fadeInDown');
        element.classList.add('fadeOutUp');

        setTimeout(() => {
            element.remove();
        }, 500);
    }, delay);
};

let $alert;

(() => {
    document.querySelectorAll('.alert:not(.sticky)').forEach((alert) => {
        closeAlert(alert);
    });

    document.body.addEventListener('click', (event) => {
        if (event.target.matches('.alert .btn-close')) {
            const alert = event.target.closest('.alert');
            if (alert) {
                alert.remove();
            }
        }
    });

})();

