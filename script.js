// Remove all HTML, <style>, and <head> tags from this file.
// Only keep JavaScript code below.

function toggleSidebar() {
    const sidebar = document.getElementById('settingsSidebar');
    sidebar.classList.toggle('active');
}

function toggleTheme() {
    document.body.classList.toggle('dark-mode');
    document.querySelector('.navbar').classList.toggle('dark-mode');
    document.querySelector('.hero-section').classList.toggle('dark-mode');
    document.querySelector('.hero-bg-img').classList.toggle('dark-mode');
    document.querySelector('.hero-overlay').classList.toggle('dark-mode');
    document.querySelector('.hero-content').classList.toggle('dark-mode');
    document.querySelectorAll('.section-title').forEach(el => el.classList.toggle('dark-mode'));
    document.querySelectorAll('.room-card').forEach(el => el.classList.toggle('dark-mode'));
    document.querySelectorAll('.amenity-box').forEach(el => el.classList.toggle('dark-mode'));
    document.querySelectorAll('.testimonial-card').forEach(el => el.classList.toggle('dark-mode'));
    document.querySelectorAll('.room-card-title').forEach(el => el.classList.toggle('dark-mode'));
    document.querySelectorAll('.btn-outline-primary').forEach(el => el.classList.toggle('dark-mode'));
    document.querySelector('footer').classList.toggle('dark-mode');
}

function changeLanguage(lang) {
    alert(`Language changed to ${lang}`);
}

function toggleAccessibility() {
    alert('Accessibility options opened');
}

function startVirtualTour() {
    alert('Starting virtual tour');
}

function openLiveChat() {
    alert('Opening live chat');
}

function showNewsletterModal() {
    const modal = new bootstrap.Modal(document.getElementById('newsletterModal'));
    modal.show();
}

function submitNewsletter() {
    const email = document.getElementById('newsletterEmail').value;
    if (email) {
        alert('Subscribed successfully!');
        document.getElementById('newsletterForm').reset();
        bootstrap.Modal.getInstance(document.getElementById('newsletterModal')).hide();
    } else {
        alert('Please enter a valid email.');
    }
}

function validateForm(event) {
    event.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    if (name && email && message) {
        alert('Message sent successfully!');
        document.getElementById('contactForm').reset();
    } else {
        alert('Please fill in all fields.');
    }
    return false;
}

function toggleDateFields() {
    var roomType = document.getElementById('roomType');
    var dateFields = document.getElementById('dateFields');
    if (!roomType || !dateFields) return;
    var value = roomType.value;
    if (value === 'daytour' || value === 'nighttour') {
        dateFields.style.display = 'none';
        document.getElementById('checkIn').required = false;
        document.getElementById('checkOut').required = false;
    } else {
        dateFields.style.display = '';
        document.getElementById('checkIn').required = true;
        document.getElementById('checkOut').required = true;
    }
}

function submitBooking() {
    var roomType = document.getElementById('roomType').value;
    var guests = document.getElementById('guests').value;
    var checkIn = document.getElementById('checkIn');
    var checkOut = document.getElementById('checkOut');
    if (roomType !== 'daytour' && roomType !== 'nighttour') {
        if (!checkIn.value || !checkOut.value || !guests || !roomType) {
            alert('Please fill in all fields.');
            return;
        }
    } else {
        if (!guests || !roomType) {
            alert('Please fill in all fields.');
            return;
        }
    }
    alert('Booking submitted successfully!');
    document.getElementById('bookingForm').reset();
    bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();
    toggleDateFields();
}

function setBookingType(type) {
    var roomType = document.getElementById('roomType');
    if (roomType) {
        let value = '';
        if (type === 'Day Tour') value = 'daytour';
        else if (type === 'Night Tour') value = 'nighttour';
        else if (type === 'Overnight Stay') value = 'overnightstay';
        let found = false;
        for (let i = 0; i < roomType.options.length; i++) {
            if (roomType.options[i].value === value) {
                roomType.selectedIndex = i;
                found = true;
                break;
            }
        }
        if (!found && value) {
            let opt = document.createElement('option');
            opt.value = value;
            opt.text = type;
            roomType.add(opt);
            roomType.value = opt.value;
        }
        toggleDateFields();
    }
}

// Loading Spinner
window.addEventListener('load', function() {
    setTimeout(() => {
        var spinner = document.getElementById('loadingSpinner');
        if (spinner) spinner.classList.add('hide');
    }, 600);
});

// Back to Top Button
window.addEventListener('DOMContentLoaded', function() {
    const backToTopBtn = document.getElementById('backToTopBtn');
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 200) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});

// Navbar background on scroll
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        if (window.scrollY > 60) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
});

// Smooth scroll for anchor links
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});

// Ensure correct fields are shown when modal opens
window.addEventListener('DOMContentLoaded', function() {
    var bookingModal = document.getElementById('bookingModal');
    if (bookingModal) {
        bookingModal.addEventListener('show.bs.modal', function () {
            toggleDateFields();
        });
    }
});

// Show/Hide Password Toggle for all password fields
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="password"]').forEach(function(pwdField) {
        // Prevent duplicate toggles
        if (pwdField.parentNode.classList.contains('password-toggle-wrapper')) return;

        // Create wrapper
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        wrapper.classList.add('password-toggle-wrapper');
        pwdField.parentNode.insertBefore(wrapper, pwdField);
        wrapper.appendChild(pwdField);

        // Create toggle button
        const toggle = document.createElement('span');
        toggle.textContent = '👁️';
        toggle.style.cursor = 'pointer';
        toggle.style.position = 'absolute';
        toggle.style.right = '10px';
        toggle.style.top = '50%';
        toggle.style.transform = 'translateY(-50%)';
        toggle.title = 'Show/Hide Password';
        wrapper.appendChild(toggle);

        toggle.addEventListener('click', function() {
            pwdField.type = pwdField.type === 'password' ? 'text' : 'password';
            toggle.textContent = pwdField.type === 'password' ? '👁️' : '🙈';
        });
    });
});