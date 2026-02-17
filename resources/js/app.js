import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import flatpickr from 'flatpickr';

window.Alpine = Alpine;
window.Swal = Swal;
window.flatpickr = flatpickr;

Alpine.start();

// Initialize Flatpickr on all date picker inputs
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initializeDatepickers, 50);
});

function initializeDatepickers() {
    const datepickers = document.querySelectorAll('.datepicker-input:not(.flatpickr-input)');
    
    console.log('Initializing flatpickr for', datepickers.length, 'inputs');
    
    datepickers.forEach(input => {
        flatpickr(input, {
            dateFormat: 'Y-m-d',
            allowInput: true,
            disableMobile: true,
            clickOpens: true,
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Ned', 'Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub'],
                    longhand: ['Nedelja', 'Ponedeljak', 'Utorak', 'Sreda', 'Četvrtak', 'Petak', 'Subota']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'],
                    longhand: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar']
                }
            }
        });
    });
}

// Make initialization function globally available for dynamic content
window.initializeDatepickers = initializeDatepickers;
