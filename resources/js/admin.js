/* ============================================
   Skoolyst Stores — Shared admin/dashboard JavaScript
   Loaded in addition to app.js on every /admin/* page.
   ============================================ */

(function () {
  "use strict";

  /* ---------- Sidebar toggle (mobile) ---------- */
  document.addEventListener("click", function (e) {
    const toggle = e.target.closest("[data-sidebar-toggle]");
    if (!toggle) return;
    const sidebar = document.querySelector(".dashboard-sidebar");
    const overlay = document.querySelector(".sidebar-overlay");
    if (sidebar) sidebar.classList.toggle("show");
    if (overlay) overlay.classList.toggle("show");
  });
  document.addEventListener("click", function (e) {
    if (e.target.closest(".sidebar-overlay")) {
      const sidebar = document.querySelector(".dashboard-sidebar");
      const overlay = document.querySelector(".sidebar-overlay");
      if (sidebar) sidebar.classList.remove("show");
      if (overlay) overlay.classList.remove("show");
    }
  });
})();
