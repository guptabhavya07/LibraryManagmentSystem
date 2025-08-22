
function openSection(sectionName,event) {
    // Hide all sections
    var sections = document.getElementsByClassName("content-section");
    for (var i = 0; i < sections.length; i++) {
        sections[i].classList.remove("active");
    }
    
    // Remove active class from all buttons
    var buttons = document.getElementsByClassName("nav-button");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("active");
    }
    
    // Show selected section
    document.getElementById(sectionName).classList.add("active");
    
    // Add active class to clicked button
    event.target.classList.add("active");
    
    // Close sidebar on mobile after selection
    if (window.innerWidth <= 992) {
        closeSidebar();
    }
}

function toggleSidebar() {
    var sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("show");
}

function closeSidebar() {
    var sidebar = document.getElementById("sidebar");
    sidebar.classList.remove("show");
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    var sidebar = document.getElementsByClassName("sidebar");
    var toggleButton = document.querySelector(".mobile-menu-toggle");
    
    if (window.innerWidth <= 992 && 
        sidebar.classList.contains("show") && 
        !sidebar.contains(event.target) && 
        !toggleButton.contains(event.target)) {
        closeSidebar();
    }
});

// Handle window resize
// window.addEventListener('resize', function() {
//     if (window.innerWidth > 992) {
//         var sidebar = document.getElementById("sidebar");
//         sidebar.classList.remove("show");
//     }
// });

// Set default active section on page load
document.addEventListener('DOMContentLoaded', function() {
    var activeSection = document.querySelector('.content-section.active');
    
    if (activeSection) {
        var sectionId = activeSection.id;
        var buttons = document.getElementsByClassName("nav-button");
        for (var i = 0; i < buttons.length; i++) {
            if (buttons[i].getAttribute('onclick') && 
                buttons[i].getAttribute('onclick').includes(sectionId)) {
                buttons[i].classList.add("active");
                break;
            }
        }
    }

    const url = new URL(window.location.href);
if (url.searchParams.has('msg')) {
url.searchParams.delete('msg');
window.history.replaceState({}, document.title, url);
}
});
