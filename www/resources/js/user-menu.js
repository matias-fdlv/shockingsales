// resources/js/user-menu.js
document.addEventListener("DOMContentLoaded", () => {
  const menu = document.getElementById("userMenu");
  const trigger = document.getElementById("userTrigger");
  const dropdown = document.getElementById("userDropdown");

  // Si no hay usuario logueado o no existe el markup, no hacemos nada
  if (!menu || !trigger || !dropdown) return;

  const getItems = () =>
    dropdown.querySelectorAll('a.menu-item, button.menu-item');

  function openMenu() {
    menu.dataset.open = "true";
    trigger.setAttribute("aria-expanded", "true");
    const items = getItems();
    if (items.length) items[0].focus();
  }

  function closeMenu() {
    delete menu.dataset.open;
    trigger.setAttribute("aria-expanded", "false");
  }

  function isOpen() {
    return menu.dataset.open === "true";
  }

  function toggleMenu() {
    isOpen() ? closeMenu() : openMenu();
  }

  // Abrir/cerrar con click en el botón
  trigger.addEventListener("click", (e) => {
    e.stopPropagation();
    toggleMenu();
  });

  // Cerrar al hacer click fuera
  document.addEventListener("click", (e) => {
    if (!isOpen()) return;
    if (!menu.contains(e.target)) closeMenu();
  });

  // Teclas: ESC para cerrar, Tab para trap, flechas para navegar
  document.addEventListener("keydown", (e) => {
    if (!isOpen()) return;

    if (e.key === "Escape") {
      closeMenu();
      trigger.focus();
      return;
    }

    const items = Array.from(getItems());
    if (!items.length) return;

    const currentIndex = items.indexOf(document.activeElement);

    if (e.key === "ArrowDown") {
      e.preventDefault();
      const next = items[(currentIndex + 1 + items.length) % items.length];
      next.focus();
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      const prev =
        items[(currentIndex - 1 + items.length) % items.length];
      prev.focus();
    } else if (e.key === "Tab") {
      // Trap de foco dentro del dropdown
      if (e.shiftKey && document.activeElement === items[0]) {
        e.preventDefault();
        items[items.length - 1].focus();
      } else if (!e.shiftKey && document.activeElement === items[items.length - 1]) {
        e.preventDefault();
        items[0].focus();
      }
    }
  });
});
