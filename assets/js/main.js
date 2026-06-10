document.addEventListener("DOMContentLoaded", () => {

  // =========================
  // GSAP + ScrollTrigger
  // =========================

  if (typeof gsap !== "undefined") {
    gsap.registerPlugin(ScrollTrigger);
  }

  // =========================
  // LENIS SMOOTH SCROLL
  // =========================

  let lenis;

  if (typeof Lenis !== "undefined") {

    lenis = new Lenis({
      duration: 1.2,
      smoothWheel: true,
      smoothTouch: false,
      wheelMultiplier: 1,
    });

    function raf(time) {

      lenis.raf(time);

      requestAnimationFrame(raf);

    }

    requestAnimationFrame(raf);

    // Sync GSAP ScrollTrigger
    lenis.on("scroll", ScrollTrigger.update);

    gsap.ticker.add((time) => {

      lenis.raf(time * 1000);

    });

    gsap.ticker.lagSmoothing(0);

  }

  // =========================
  // LOADER
  // =========================

  window.addEventListener("load", () => {

    const loader =
      document.getElementById("loader");

    if (loader && typeof gsap !== "undefined") {

      gsap.to(loader, {
        opacity: 0,
        duration: 1,
        ease: "power3.out",
        delay: 0.4,
        onComplete: () => {
          loader.style.display = "none";
        },
      });

    }

  });

  // =========================
  // MOBILE MENU
  // =========================

  const menuBtn =
    document.getElementById("menu-btn");

  const mobileMenu =
    document.getElementById("mobile-menu");

  if (menuBtn && mobileMenu) {

    menuBtn.addEventListener("click", () => {

      mobileMenu.classList.toggle("hidden");

      if (
        !mobileMenu.classList.contains("hidden")
      ) {

        gsap.fromTo(
          mobileMenu,
          {
            opacity: 0,
            y: -30,
            scale: 0.96,
          },
          {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 0.6,
            ease: "power4.out",
          }
        );

      }

    });

  }

  // =========================
  // NAVBAR SCROLL EFFECT
  // =========================

  const navbar =
    document.getElementById("navbar");

  window.addEventListener("scroll", () => {

    if (!navbar) return;

    if (window.scrollY > 50) {

      navbar.classList.add(
        "nav-scrolled"
      );

    } else {

      navbar.classList.remove(
        "nav-scrolled"
      );

    }

  });

  // =========================
  // SCROLL PROGRESS BAR
  // =========================

  const progressBar =
    document.getElementById("progress-bar");

  window.addEventListener("scroll", () => {

    if (!progressBar) return;

    const scrollTop =
      document.documentElement.scrollTop;

    const scrollHeight =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight;

    const scrollPercent =
      (scrollTop / scrollHeight) * 100;

    progressBar.style.width =
      scrollPercent + "%";

  });

  // =========================
  // PREMIUM CURSOR GLOW
  // =========================

  const glow =
    document.getElementById("cursor-glow");

  if (glow && typeof gsap !== "undefined") {

    window.addEventListener("mousemove", (e) => {

      gsap.to(glow, {
        x: e.clientX - 70,
        y: e.clientY - 70,
        duration: 0.5,
        ease: "power3.out",
      });

    });

  }

  // =========================
  // HERO MASTER TIMELINE
  // =========================

  if (typeof gsap !== "undefined") {

    const heroTl =
      gsap.timeline();

    heroTl

      .from(".hero-bg", {

        scale: 1.4,
        duration: 2.4,
        ease: "power3.out",

      })

      .from(".hero-subtitle", {

        y: 100,
        opacity: 0,
        duration: 1,
        ease: "power4.out",

      }, "-=1.8")

      .from(".hero-title", {

        y: 140,
        opacity: 0,
        duration: 1.6,
        ease: "expo.out",

      }, "-=1")

      .from(".hero-description", {

        y: 60,
        opacity: 0,
        duration: 1,

      }, "-=1.1")

      .from(".hero-btn", {

        y: 50,
        opacity: 0,
        stagger: 0.15,
        duration: 1,
        ease: "power4.out",

      }, "-=0.7");

  }

  // =========================
  // HERO PARALLAX
  // =========================

  if (typeof gsap !== "undefined") {

    gsap.to(".hero-bg", {

      yPercent: 15,
      scale: 1.2,
      ease: "none",

      scrollTrigger: {
        trigger: "#home",
        start: "top top",
        end: "bottom top",
        scrub: true,
      },

    });

  }

  // =========================
  // SERVICES ANIMATION
  // =========================

  if (typeof gsap !== "undefined") {

    gsap.from(".service-card", {

      y: 120,
      opacity: 0,
      stagger: 0.2,
      duration: 1.4,
      ease: "power4.out",

      scrollTrigger: {
        trigger: "#services",
        start: "top 70%",
      },

    });

  }

  // =========================
  // ABOUT SECTION
  // =========================

  if (typeof gsap !== "undefined") {

    gsap.from(".about-title", {

      y: 100,
      opacity: 0,
      duration: 1.3,
      ease: "power4.out",

      scrollTrigger: {
        trigger: ".about-title",
        start: "top 80%",
      },

    });

    gsap.from(".about-feature", {

      y: 80,
      opacity: 0,
      stagger: 0.2,
      duration: 1.1,
      ease: "power4.out",

      scrollTrigger: {
        trigger: ".about-feature",
        start: "top 88%",
      },

    });

  }

  // =========================
  // GALLERY PARALLAX
  // =========================

  if (typeof gsap !== "undefined") {

    gsap.utils.toArray(".gallery-card")
      .forEach((card) => {

        const image =
          card.querySelector("img");

        gsap.to(image, {

          yPercent: -20,
          ease: "none",

          scrollTrigger: {
            trigger: card,
            start: "top bottom",
            end: "bottom top",
            scrub: true,
          },

        });

      });

  }

  // =========================
  // SECTION REVEAL
  // =========================

  if (typeof gsap !== "undefined") {

    gsap.utils.toArray("section")
      .forEach((section) => {

        if (section.id === "home")
          return;

        gsap.from(section, {

          opacity: 0,
          y: 100,
          duration: 1.4,
          ease: "power4.out",

          scrollTrigger: {
            trigger: section,
            start: "top 80%",
          },

        });

      });

  }

  // =========================
  // FAQ ACCORDION
  // =========================

  const faqButtons =
    document.querySelectorAll(".faq-btn");

  faqButtons.forEach((button) => {

    button.addEventListener("click", () => {

      const content =
        button.nextElementSibling;

      const icon =
        button.querySelector(".faq-icon");

      if (!content || !icon) return;

      const isHidden =
        content.classList.contains("hidden");

      document
        .querySelectorAll(".faq-content")
        .forEach((item) => {

          item.classList.add("hidden");

        });

      document
        .querySelectorAll(".faq-icon")
        .forEach((item) => {

          item.textContent = "+";

        });

      if (isHidden) {

        content.classList.remove("hidden");

        icon.textContent = "−";

        gsap.fromTo(
          content,
          {
            height: 0,
            opacity: 0,
          },
          {
            height: "auto",
            opacity: 1,
            duration: 0.5,
            ease: "power3.out",
          }
        );

      }

    });

  });

  // =========================
  // ACTIVE NAVIGATION
  // =========================

  const sections =
    document.querySelectorAll("section");

  const navLinks =
    document.querySelectorAll("nav a");

  window.addEventListener("scroll", () => {

    let current = "";

    sections.forEach((section) => {

      const sectionTop =
        section.offsetTop;

      const sectionHeight =
        section.clientHeight;

      if (
        window.scrollY >=
        sectionTop - 250
      ) {

        current =
          section.getAttribute("id");

      }

    });

    navLinks.forEach((link) => {

      link.classList.remove(
        "text-[#e7d1be]"
      );

      if (
        link.getAttribute("href") ===
        `#${current}`
      ) {

        link.classList.add(
          "text-[#e7d1be]"
        );

      }

    });

  });

  // =========================
  // COUNTER ANIMATION
  // =========================

  const counters =
    document.querySelectorAll(".counter");

  counters.forEach((counter) => {

    let started = false;

    const updateCounter = () => {

      if (started) return;

      started = true;

      const target =
        +counter.getAttribute("data-target");

      let count = 0;

      const increment =
        target / 140;

      const interval =
        setInterval(() => {

          count += increment;

          if (count >= target) {

            counter.innerText =
              target.toLocaleString() + "+";

            clearInterval(interval);

          } else {

            counter.innerText =
              Math.ceil(count);

          }

        }, 18);

    };

    if (typeof ScrollTrigger !== "undefined") {

      ScrollTrigger.create({

        trigger: counter,
        start: "top 90%",
        onEnter: updateCounter,

      });

    }

  });

});