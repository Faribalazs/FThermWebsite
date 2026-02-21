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

// Mobile overlay element (lazy-created)
let mobileOverlay = null;
function getMobileOverlay() {
    if (!mobileOverlay) {
        mobileOverlay = document.createElement('div');
        mobileOverlay.className = 'flatpickr-mobile-overlay';
        document.body.appendChild(mobileOverlay);
    }
    return mobileOverlay;
}

const isMobile = () => window.innerWidth <= 640;

function initializeDatepickers() {
    const datepickers = document.querySelectorAll('.datepicker-input:not(.flatpickr-input)');
    
    datepickers.forEach(input => {
        const fp = flatpickr(input, {
            dateFormat: 'Y-m-d',
            allowInput: false,
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
            },
            onReady: function(selectedDates, dateStr, instance) {
                // Add "Today" button footer
                const footer = document.createElement('div');
                footer.className = 'flatpickr-footer';
                
                const todayBtn = document.createElement('button');
                todayBtn.type = 'button';
                todayBtn.className = 'fp-today-btn';
                todayBtn.textContent = 'Danas';
                todayBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    instance.setDate(new Date(), true);
                    instance.close();
                    // Trigger Alpine reactivity
                    input.dispatchEvent(new Event('change'));
                });
                
                footer.appendChild(todayBtn);
                instance.calendarContainer.appendChild(footer);
            },
            onOpen: function(selectedDates, dateStr, instance) {
                if (isMobile()) {
                    const overlay = getMobileOverlay();
                    overlay.classList.add('active');
                    overlay.onclick = () => instance.close();
                    // Prevent body scroll on mobile
                    document.body.style.overflow = 'hidden';
                }
            },
            onClose: function(selectedDates, dateStr, instance) {
                const overlay = getMobileOverlay();
                overlay.classList.remove('active');
                document.body.style.overflow = '';
                // Trigger Alpine reactivity for clear button
                input.dispatchEvent(new Event('change'));
            },
            onChange: function(selectedDates, dateStr, instance) {
                input.dispatchEvent(new Event('change'));
            }
        });
    });
}

// Make initialization function globally available for dynamic content
window.initializeDatepickers = initializeDatepickers;
