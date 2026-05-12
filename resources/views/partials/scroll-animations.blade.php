<style>
    /* Scroll-reveal base */
    [data-reveal] {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
    }
    [data-reveal="fade"] {
        transform: none;
    }
    [data-reveal].is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Navbar scroll shadow */
    .nav-scrolled {
        box-shadow: 0 4px 24px -4px rgba(0,0,0,.08);
    }
</style>
<script>
(function () {
    /* Scroll-reveal via IntersectionObserver */
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var delay = parseInt(el.dataset.revealDelay || '0', 10);
                setTimeout(function () { el.classList.add('is-visible'); }, delay);
                io.unobserve(el);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

    function initReveal() {
        document.querySelectorAll('[data-reveal]').forEach(function (el) {
            io.observe(el);
        });
    }

    /* Navbar shadow on scroll */
    function initNavScroll() {
        var nav = document.querySelector('nav');
        if (!nav) return;
        var onScroll = function () {
            nav.classList.toggle('nav-scrolled', window.scrollY > 8);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { initReveal(); initNavScroll(); });
    } else {
        initReveal(); initNavScroll();
    }
})();
</script>
