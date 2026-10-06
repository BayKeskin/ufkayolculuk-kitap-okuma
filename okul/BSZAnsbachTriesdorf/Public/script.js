document.addEventListener("DOMContentLoaded", function () {
  let linkss = document.links;
  for (let i = 0, linksLength = linkss.length; i < linksLength; i++) {
    if (linkss[i].hostname !== window.location.hostname) {
      linkss[i].target = "_blank";
      linkss[i].rel = "noreferrer noopener";
    }
  }

  const copyButtons = document.querySelectorAll(".copybutton");
  if (copyButtons.length > 0) {
    copyButtons.forEach((button) => {
      button.addEventListener("click", (event) => {
        navigator.clipboard
          .writeText(window.location.href)
          .then(function () {})
          .catch(function (error) {});
        if (button.querySelector(".success-message")) {
          button.querySelector(".success-message").classList.add("show");
          setTimeout(function () {
            button.querySelector(".success-message").classList.remove("show");
          }, 2000);
        }
      });
    });
  }

  /*const submenuButtons = document.querySelectorAll("button.has-submenu");

  submenuButtons.forEach((button) => {
    button.addEventListener("click", function () {
      if (this.classList.contains("active")) {
        this.classList.remove("active");
        return;
      }
      if (!this.classList.contains("has-submenu-mobile")) {
        submenuButtons.forEach((btn) => {
          btn.classList.remove("active");
        });
      }
      this.classList.add("active");
    });
  });*/

  const submenuButtons = document.querySelectorAll("button.has-submenu");

  submenuButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.stopPropagation();

      const isActive = this.classList.contains("active");

      // 1. Nur Geschwister auf der GLEICHEN Ebene schließen
      // Wir suchen den direkten Container, um nicht die ganze Seite zu beeinflussen
      const parentList = this.closest('ul');
      if (parentList) {
        // Suche nur Buttons, die direkte Kinder der Listenpunkte dieser Ebene sind
        const siblingButtons = parentList.querySelectorAll(':scope > li > .has-submenu');
        siblingButtons.forEach((btn) => {
          if (btn !== this) {
            closeMenu(btn);
          }
        });
      }

      // 2. Den geklickten Button umschalten
      if (isActive) {
        closeMenu(this); // Schließt sich selbst und alles darunter
      } else {
        this.classList.add("active");
        this.setAttribute("aria-expanded", "true");
      }
    });
  });

// Hilfsfunktion: Schließt den Button und alle tiefer verschachtelten Buttons
  function closeMenu(btn) {
    btn.classList.remove("active");
    btn.setAttribute("aria-expanded", "false");

    // Suche in dem dazugehörigen Submenü nach weiteren Buttons und schließe diese
    const parentLi = btn.parentElement;
    const nestedButtons = parentLi.querySelectorAll("button.has-submenu");
    nestedButtons.forEach(nestedBtn => {
      nestedBtn.classList.remove("active");
      nestedBtn.setAttribute("aria-expanded", "false");
    });
  }

  document.addEventListener("click", function (event) {
    const header = document.querySelector(".header");
    if (!header.contains(event.target)) {
      submenuButtons.forEach((button) => {
        button.classList.remove("active");
      });
    }
  });

  // Hole das Button-Element mit der ID
  const toggleButton = document.getElementById("toggleButton");

  // Füge einen Klick-Listener hinzu
  toggleButton.addEventListener("click", function () {
    // Toggle die Klasse "open" auf dem Button-Element
    if (toggleButton.classList.contains("open")) {
      // Entferne die Klasse 'open'
      toggleButton.classList.remove("open");
      toggleButton.setAttribute("aria-expanded", "false");
    } else {
      // Füge die Klasse 'open' hinzu
      toggleButton.classList.add("open");
      toggleButton.setAttribute("aria-expanded", "true");
    }
    var bodyelement = document.querySelector("body");
    if (bodyelement.classList.contains("fix-body")) {
      // bodyelement.classList.remove("overflow-hidden");
      bodyelement.classList.remove("fix-body");
    } else {
      // bodyelement.classList.add("overflow-hidden");
      bodyelement.classList.add("fix-body");
    }
  });

  //Modals
  let modals = document.querySelectorAll(".modal");
  if (modals.length > 0) {
  }

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" || event.key === "Esc") {
      // Entferne die Klasse 'open' vom Popup-Wrapper
      if (modals.length > 0) {
        // Entferne die Klasse 'open' von jedem gefundenen Element
        modals.forEach(function (modal) {
          modal.classList.remove("open");
          document.body.removeAttribute("data-lenis-prevent");
        });
      }
    }
  });

  document.querySelectorAll(".close-button").forEach((button) => {
    button.addEventListener("click", () => {
      // Findet das nächstgelegene Elternelement mit der Klasse .modal
      const modal = button.closest(".modal");
      if (modal) {
        modal.classList.remove("open");
        document.body.removeAttribute("data-lenis-prevent");
      }
    });
  });



  document.querySelectorAll(".open-wichtige-termine-button").forEach((button) => {
    button.addEventListener("click", () => {
      // Findet das nächstgelegene Elternelement mit der Klasse .modal
      const modal = document.querySelector(".termine-modal");
      if (modal) {
        modal.classList.add("open");
        document.body.setAttribute("data-lenis-prevent", "true");

      }
    });
  });


  document.querySelectorAll(".open-downloads-button").forEach((button) => {
    button.addEventListener("click", () => {
      // Findet das nächstgelegene Elternelement mit der Klasse .modal
      const modal = document.querySelector(".downloads-modal");
      if (modal) {
        modal.classList.add("open");
        document.body.setAttribute("data-lenis-prevent", "true");
      }
    });
  });


  document.querySelectorAll(".open-kontakt-button").forEach((button) => {
    button.addEventListener("click", () => {
      // Findet das nächstgelegene Elternelement mit der Klasse .modal
      const modal = document.querySelector(".kontakt-modal");
      if (modal) {
        modal.classList.add("open");
        document.body.setAttribute("data-lenis-prevent", "true");
      }
    });
  });



  //Accordion
  const accordionButtons = document.querySelectorAll(".accordion-button");

  accordionButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const target = document.getElementById(
        button.getAttribute("aria-controls")
      );
      const isOpen = target.classList.contains("show");

      if (isOpen) {
        // Collapse the accordion
        target.style.height = `${target.scrollHeight}px`;
        // Force reflow for the transition to kick in
        target.offsetHeight;
        target.style.height = "0px";
        button.setAttribute("aria-expanded", "false");

        target.addEventListener("transitionend", function onTransitionEnd() {
          target.classList.remove("show");
          target.style.height = "";
          target.removeEventListener("transitionend", onTransitionEnd);
        });
      } else {
        // Expand the accordion
        target.style.height = "0px";
        target.classList.add("show");
        button.setAttribute("aria-expanded", "true");
        target.offsetHeight;
        target.style.height = `${target.scrollHeight}px`;

        target.addEventListener("transitionend", function onTransitionEnd() {
          target.style.height = "auto";
          target.removeEventListener("transitionend", onTransitionEnd);
        });
      }
    });
  });

  let othersImageSwiper = document.querySelector(".others-image-swiper");

  if (othersImageSwiper) {
    let currentSlideIndex = 0;
    let currentSlideElement = othersImageSwiper.querySelector(
      ".current-swiper-slide"
    );

    function updateSlideNumber() {
      if (swiperImageLeft) {
        currentSlideIndex = swiperImageLeft.realIndex;
      }
      currentSlideElement.textContent = (currentSlideIndex + 1).toLocaleString(
        "en-US",
        {
          minimumIntegerDigits: 2,
          useGrouping: false,
        }
      );
    }

    if (window.innerWidth > 768) {
      var swiperImageLeft = new Swiper(".others-image-swiper .swiper-left", {
        slidesPerView: 1,
        loop: true,
        effect: "fade",
        allowTouchMove: false,
        on: {
          slideChange: updateSlideNumber,
        },
      });
    } else {
      var swiperImageLeft = new Swiper(".others-image-swiper .swiper-left", {
        slidesPerView: 1,
        loop: true,
        effect: "fade",
        on: {
          slideChange: updateSlideNumber,
        },
      });
    }

    var swiperImageRight = new Swiper(".swiper-image-right", {
      slidesPerView: "auto",
      spaceBetween: 20,
      loop: true,
      allowTouchMove: false,
    });
    const sliderBackward = othersImageSwiper.querySelector(
      ".card-slider-backward"
    );
    const sliderForward = othersImageSwiper.querySelector(
      ".card-slider-forward"
    );
    if (sliderBackward) {
      sliderBackward.addEventListener("click", () => {
        swiperImageLeft.slidePrev();
        swiperImageRight.slidePrev();
      });
    }
    if (sliderForward) {
      sliderForward.addEventListener("click", () => {
        swiperImageLeft.slideNext();
        swiperImageRight.slideNext();
      });
    }
  }
});

document.addEventListener("DOMContentLoaded", (event) => {
  const lenis = new Lenis();
  if (document.querySelector(".back-to-top")) {
    document.querySelector(".back-to-top").addEventListener("click", () => {
      lenis.scrollTo(0);
    });
  }

  lenis.on("scroll", ScrollTrigger.update);

  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });

  gsap.ticker.lagSmoothing(0);

  gsap.registerPlugin(ScrollTrigger);

  // create
  let mm = gsap.matchMedia();

  mm.add("(min-width: 768.1px)", () => {
    let parallax_images = document.querySelectorAll(".img-wrapper-animation");
    if (parallax_images.length > 0) {
      parallax_images.forEach((image) => {
        let realImage = image.querySelector("img");
        let tl = gsap.timeline({
          scrollTrigger: {
            trigger: image,
            scrub: 2,
          },
          defaults: {
            ease: "none",
          },
        });
        tl.fromTo(
          realImage,
          {
            yPercent: 10,
          },
          {
            yPercent: -10,
          }
        );
      });
    }

    //Marquee
    let marqueeContainer = document.querySelectorAll(
      ".marquee-container.every-time"
    );
    if (marqueeContainer.length > 0) {
      marqueeContainer.forEach((el) => {
        let marquee = el.querySelectorAll(".marquee-grid");
        let direction = el.classList.contains("reverse") ? 100 : -100;
        gsap.to(marquee, {
          xPercent: direction,
          ease: "none",
          duration: 20,
          repeat: -1,
        });
      });
    }
  });

  let scaleUpElements = gsap.utils.toArray(".scale-up-scroll");

  if (scaleUpElements.length > 0) {
    gsap.set(scaleUpElements, { scale: 0 });

    scaleUpElements.forEach((element) => {
      gsap.to(element, {
        scale: 1,
        duration: 1,
        ease: "power4.out",
        scrollTrigger: {
          trigger: element,
          start: "top 80%",
          toggleActions: "play none none none",
        },
      });
    });
  }


  const ansprechpartnerSliderElement = document.querySelector(
      ".ansprechpartner-slider",
  );

  if (ansprechpartnerSliderElement) {
    const swiperInstanz = new Swiper(ansprechpartnerSliderElement, {
      spaceBetween: 20,
      slidesPerView: 2,
      loop: true,
      autoplay: {
        delay: 2000,
        disableOnInteraction: false,
      },
      breakpoints: {
        420: {
          slidesPerView: 3,
        },
        650: {
          slidesPerView: 4,
        },
        // Ab 600px (Desktop/Tablet) Autoplay ausschalten
        1300: {
          slidesPerView: 4,
          autoplay: false, // Deaktiviert Autoplay ab dieser Breite
        },
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }
});


