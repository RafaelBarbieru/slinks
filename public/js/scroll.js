document.documentElement.style.scrollBehavior = 'auto';

window.onbeforeunload = function(e) {
    localStorage.setItem('scrollpos', window.scrollY);
};

document.addEventListener("DOMContentLoaded", function(e) {
        var scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos) window.scrollTo(0, scrollpos);
});