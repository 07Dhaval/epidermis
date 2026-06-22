document.addEventListener("DOMContentLoaded", () => {
  const ctas = document.querySelectorAll(".site-cta");

  if (!ctas.length) return;

  if (!("IntersectionObserver" in window)) {
    ctas.forEach((cta) => cta.classList.add("cta-visible", "is-visible"));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        entry.target.classList.add("cta-visible", "is-visible");
        observer.unobserve(entry.target);
      });
    },
    {
      threshold: 0.18,
      rootMargin: "0px 0px -40px",
    },
  );

  ctas.forEach((cta) => observer.observe(cta));
});
