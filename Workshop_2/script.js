// SECTION SWITCHING
function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');

    sections.forEach(sec => sec.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
}

// MOBILE MENU TOGGLE
const menuButton = document.getElementById('menu-button');
const navLinks = document.getElementById('nav-links');

if (menuButton && navLinks) {
    menuButton.addEventListener('click', () => {
        navLinks.classList.toggle('open');

        const expanded = navLinks.classList.contains('open');
        menuButton.setAttribute('aria-expanded', expanded);
        menuButton.textContent = expanded ? '✕' : '☰';
    });
}

// FORM VALIDATION
const contactForm = document.getElementById('contact-form');
const formMessage = document.getElementById('form-message');

if (contactForm && formMessage) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();

        if (!name || !email || !message) {
            formMessage.textContent = 'Please fill in all the fields before submitting.';
            formMessage.style.color = 'red';
            return;
        }

        formMessage.textContent = 'Thank you for your message! I will get back to you soon.';
        formMessage.style.color = 'lightgreen';
        contactForm.reset();
    });
}
