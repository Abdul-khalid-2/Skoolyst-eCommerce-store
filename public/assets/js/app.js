/* ============================================
   Skoolyst Stores — Shared storefront JavaScript
   Vanilla JS only — no frameworks, no jQuery.
   Active nav state is set server-side (PHP); this
   file only owns client-side interaction/state.
   ============================================ */

(function () {
  "use strict";

  /* ---------- Cart (localStorage — no backend cart yet) ---------- */
  const CART_KEY = "skoolyst_cart";

  function getCart() {
    try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; }
    catch { return []; }
  }
  function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    updateCartBadge();
  }
  function updateCartBadge() {
    const cart = getCart();
    const total = cart.reduce((s, i) => s + i.qty, 0);
    document.querySelectorAll(".cart-count").forEach(el => {
      el.textContent = total;
      el.style.display = total > 0 ? "flex" : "none";
    });
  }
  window.skAddToCart = function (name, price, img, store) {
    const cart = getCart();
    const existing = cart.find(i => i.name === name);
    if (existing) { existing.qty++; } else {
      cart.push({ name, price, img, store, qty: 1 });
    }
    saveCart(cart);
    showToast(name + " added to cart");
  };
  window.skRemoveFromCart = function (index) {
    const cart = getCart();
    cart.splice(index, 1);
    saveCart(cart);
    if (typeof window.renderCart === "function") window.renderCart();
  };
  window.skUpdateQty = function (index, delta) {
    const cart = getCart();
    if (!cart[index]) return;
    cart[index].qty = Math.max(1, cart[index].qty + delta);
    saveCart(cart);
    if (typeof window.renderCart === "function") window.renderCart();
  };
  window.getCart = getCart;

  /* ---------- Toast notifications ---------- */
  function showToast(msg) {
    let container = document.querySelector(".toast-container");
    if (!container) {
      container = document.createElement("div");
      container.className = "toast-container";
      document.body.appendChild(container);
    }
    const toast = document.createElement("div");
    toast.className = "sk-toast";
    toast.innerHTML =
      '<span class="toast-icon"><i class="bi bi-check-circle-fill"></i></span>' +
      '<span class="toast-msg"></span>';
    toast.querySelector(".toast-msg").textContent = msg;
    container.appendChild(toast);
    setTimeout(() => {
      toast.style.opacity = "0";
      toast.style.transform = "translateX(20px)";
      toast.style.transition = "opacity .25s, transform .25s";
      setTimeout(() => toast.remove(), 250);
    }, 2500);
  }
  window.skShowToast = showToast;

  /* ---------- Quantity selector ---------- */
  document.addEventListener("click", function (e) {
    const btn = e.target.closest("[data-qty-btn]");
    if (!btn) return;
    const wrapper = btn.closest(".quantity-selector");
    const input = wrapper ? wrapper.querySelector("input[data-qty]") : null;
    if (!input) return;
    let val = parseInt(input.value) || 1;
    val += btn.dataset.qtyBtn === "plus" ? 1 : -1;
    input.value = Math.max(1, val);
    input.dispatchEvent(new Event("change", { bubbles: true }));
  });

  /* ---------- Add to cart buttons ---------- */
  document.addEventListener("click", function (e) {
    const btn = e.target.closest("[data-add-cart]");
    if (!btn) return;
    e.preventDefault();
    const name = btn.dataset.name || "Product";
    const price = parseFloat(btn.dataset.price) || 0;
    const img = btn.dataset.img || "";
    const store = btn.dataset.store || "";
    window.skAddToCart(name, price, img, store);
  });

  /* ---------- Gallery thumbnail switcher (product page) ---------- */
  document.addEventListener("click", function (e) {
    const thumb = e.target.closest(".gallery-thumb");
    if (!thumb) return;
    const main = document.querySelector(".gallery-main img");
    if (!main) return;
    const thumbImg = thumb.querySelector("img");
    if (thumbImg) main.src = thumbImg.src;
    document.querySelectorAll(".gallery-thumb").forEach(t => t.classList.remove("active"));
    thumb.classList.add("active");
  });

  /* ---------- Filter sidebar toggle (mobile) ---------- */
  document.addEventListener("click", function (e) {
    const toggle = e.target.closest("[data-filter-toggle]");
    if (!toggle) return;
    const sidebar = document.querySelector("[data-filter-sidebar]");
    if (sidebar) {
      sidebar.style.display = sidebar.style.display === "block" ? "" : "block";
    }
  });

  /* ---------- Follow / save store button ---------- */
  document.addEventListener("click", function (e) {
    const btn = e.target.closest("[data-follow-btn]");
    if (!btn) return;
    e.preventDefault();
    btn.classList.toggle("active");
    const isFollowing = btn.classList.contains("active");
    if (btn.dataset.followText) {
      btn.innerHTML = isFollowing
        ? '<i class="bi bi-bookmark-check-fill"></i> ' + (btn.dataset.followingText || "Following")
        : '<i class="bi bi-bookmark-plus"></i> ' + btn.dataset.followText;
    }
    showToast(isFollowing ? "Store saved" : "Store unfollowed");
  });

  /* ---------- Basic client-side form validation ---------- */
  document.addEventListener("submit", function (e) {
    const form = e.target.closest("[data-validate]");
    if (!form) return;
    let valid = true;
    form.querySelectorAll("[required]").forEach(field => {
      if (!field.value.trim()) {
        valid = false;
        field.classList.add("is-invalid");
      } else {
        field.classList.remove("is-invalid");
      }
      if (field.type === "email" && field.value) {
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
          valid = false;
          field.classList.add("is-invalid");
        }
      }
      if (field.dataset.match && field.value) {
        const match = form.querySelector('[name="' + field.dataset.match + '"]');
        if (match && match.value !== field.value) {
          valid = false;
          field.classList.add("is-invalid");
        }
      }
    });
    if (!valid) {
      e.preventDefault();
      showToast("Please fill in all required fields correctly");
    }
    // Otherwise let the form submit normally to the server route.
  });

  /* ---------- Tab persistence via ?tab= (store profile, settings) ---------- */
  const activeTab = new URLSearchParams(location.search).get("tab");
  if (activeTab) {
    const tabBtn = document.querySelector('[data-bs-toggle="tab"][href="#' + activeTab + '"]');
    if (tabBtn && window.bootstrap) { new bootstrap.Tab(tabBtn).show(); }
  }

  /* ---------- Init ---------- */
  document.addEventListener("DOMContentLoaded", updateCartBadge);

})();
