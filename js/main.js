document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Loading Screen Smooth Out
    const loader = document.querySelector('.loader-wrapper');
    if(loader) {
        window.addEventListener('load', () => {
            loader.style.opacity = '0';
            setTimeout(() => loader.style.display = 'none', 500);
        });
    }

    // 2. Navbar Smart Scroll
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        // Tambah background saat scroll
        if (currentScroll > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        lastScroll = currentScroll;
    });

    // 3. Mobile Menu Toggle
    const burger = document.querySelector('.burger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (burger) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }

    // 4. Hero Slider dengan Efek "Ken Burns" (Zoom Perlahan)
    const slides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    if(slides.length > 0) {
        slides[0].classList.add('active'); // Set awal
        setInterval(nextSlide, 6000); // Ganti tiap 6 detik
    }

    // 5. Advanced Scroll Animations (Staggered/Berurutan)
    // Ini yang membuat efek website mahal
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Stop observing setelah muncul
            }
        });
    }, observerOptions);

    // Targetkan elemen
    const animatedElements = document.querySelectorAll('.service-card, .feature-item, .section-title, .why-mdn-content > div');
    
    animatedElements.forEach((el) => {
        el.classList.add('fade-in-up'); // Tambah class dasar CSS
        observer.observe(el);
    });

    // Tambahkan delay bertingkat (Staggering Effect) untuk Grid
    const grids = document.querySelectorAll('.services-grid, .features-grid, .testimonials-grid');
    grids.forEach(grid => {
        const children = grid.children;
        for(let i = 0; i < children.length; i++) {
            children[i].style.transitionDelay = `${i * 0.1}s`; // Delay 0.1s, 0.2s, 0.3s...
        }
    });

    // 6. Smooth Scroll untuk Link
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                // Close mobile menu if open
                if(navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                    burger.classList.remove('active');
                }
                
                const headerOffset = 70;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
    
                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            }
        });
    });
});