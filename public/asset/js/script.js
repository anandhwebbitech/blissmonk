document.addEventListener("DOMContentLoaded", () => {
  const accItems = document.querySelectorAll(".trdd-acc-item");

  accItems.forEach((item) => {
    const btn = item.querySelector(".trdd-acc-btn");
    const panel = item.querySelector(".trdd-acc-panel");

    btn.addEventListener("click", () => {
      const isOpen = item.classList.contains("is-open");

      // Optional: Close all other accordions (Comment out if you want multiple open at once)
      accItems.forEach((otherItem) => {
        if (otherItem !== item) {
          otherItem.classList.remove("is-open");
          otherItem.querySelector(".trdd-acc-panel").style.maxHeight = null;
        }
      });

      if (!isOpen) {
        item.classList.add("is-open");
        // Calculate exact scroll height for smooth, dynamic animation
        panel.style.maxHeight = panel.scrollHeight + "px";
      } else {
        item.classList.remove("is-open");
        panel.style.maxHeight = null;
      }
    });
  });
});

// scroll
const scrollBtn = document.getElementById("dftt-scroll-btn");

// Show button when scrolled down
window.addEventListener("scroll", () => {
  if (window.scrollY > 300) {
    scrollBtn.style.display = "flex";
  } else {
    scrollBtn.style.display = "none";
  }
});

// Scroll to top smoothly
scrollBtn.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});

// model
document.addEventListener("DOMContentLoaded", () => {
  const openBtns = document.querySelectorAll(".open-modal-btn");
  const closeBtn = document.getElementById("closeModalBtn");
  const modal = document.getElementById("registrationModal");

  // Attach click events to both buttons
  openBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault(); // Stops page jump for buttons using href="#"
      modal.classList.add("active");
      document.body.style.overflow = "hidden"; // Lock page scroll
    });
  });

  // Close Modal via 'X' icon
  closeBtn.addEventListener("click", () => {
    modal.classList.remove("active");
    document.body.style.overflow = "";
  });

  // Close Modal by clicking the dark space outside the form layout frame
  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.remove("active");
      document.body.style.overflow = "";
    }
  });
});
