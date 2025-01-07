document.addEventListener("DOMContentLoaded", () => {
  const hoverElements = document.querySelectorAll("[data-id]");

  hoverElements.forEach((hoverElement) => {
    hoverElement.addEventListener("mouseenter", () => {
      const id = hoverElement.getAttribute("data-id");
      const descElement = document.querySelector(`[desc-id="${id}"]`);
      if (descElement) {
        descElement.style.display = "block";
      }
    });

    hoverElement.addEventListener("mouseleave", () => {
      const id = hoverElement.getAttribute("data-id");
      const descElement = document.querySelector(`[desc-id="${id}"]`);
      if (descElement) {
        descElement.style.display = "none";
      }
    });
  });
});
