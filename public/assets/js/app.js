/* ============================================
   Skoolyst Stores — Shared storefront JavaScript
   Vanilla JS only — no frameworks, no jQuery.
   Active nav state is set server-side (PHP); this
   file only owns client-side interaction/state.
   ============================================ */

(function () {
  "use strict";

  /* ---------- CSRF + small fetch helper ---------- */
  function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : "";
  }
  function postForm(url, params) {
    params._csrf = csrfToken();
    const body = new URLSearchParams(params);
    return fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: body.toString(),
    }).then(r => r.json());
  }

  /* ---------- Cart badge (server-driven counts) ---------- */
  function setBadge(selector, count) {
    document.querySelectorAll(selector).forEach(el => {
      el.textContent = count;
      el.style.display = count > 0 ? "" : "none";
    });
  }
  window.skUpdateCartBadge = function (count) { setBadge(".cart-count", count); };
  window.skUpdateFavoriteBadge = function (count) { setBadge(".favorite-count", count); };

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
    if (!btn || btn.disabled) return;
    e.preventDefault();
    const id = btn.dataset.id;
    const card = btn.closest(".product-card, .col-lg-6, main");
    const qtyInput = card ? card.querySelector("[data-qty]") : null;
    const qty = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;
    btn.disabled = true;
    postForm(window.SK_URL_BASE + "cart/add", { product_id: id, qty: qty })
      .then(function (res) {
        showToast(res.message || (res.ok ? "Added to cart" : "Could not add to cart"));
        if (res.ok) window.skUpdateCartBadge(res.count);
      })
      .catch(function () { showToast("Something went wrong. Please try again."); })
      .finally(function () { btn.disabled = false; });
  });

  /* ---------- Favorite toggle buttons ---------- */
  document.addEventListener("click", function (e) {
    const btn = e.target.closest("[data-favorite-toggle]");
    if (!btn) return;
    e.preventDefault();
    const id = btn.dataset.id;
    postForm(window.SK_URL_BASE + "favorites/toggle/" + id, {})
      .then(function (res) {
        if (!res.ok) return;
        btn.classList.toggle("active", res.isFavorite);
        const icon = btn.querySelector("i");
        if (icon) icon.className = res.isFavorite ? "bi bi-heart-fill" : "bi bi-heart";
        btn.setAttribute("aria-label", res.isFavorite ? "Remove from favorites" : "Add to favorites");
        window.skUpdateFavoriteBadge(res.count);
        showToast(res.isFavorite ? "Added to favorites" : "Removed from favorites");
      })
      .catch(function () { showToast("Something went wrong. Please try again."); });
  });

  /* ---------- Live image preview on file inputs ---------- */
  document.addEventListener("change", function (e) {
    const input = e.target;
    if (input.tagName !== "INPUT" || input.type !== "file") return;
    const file = input.files && input.files[0];
    if (!file || file.type.indexOf("image/") !== 0) return;

    const scope = input.closest(".form-card") || input.parentElement;
    const preview = scope ? scope.querySelector("[data-file-preview]") : null;
    if (!preview) return;

    const reader = new FileReader();
    reader.onload = function (ev) {
      preview.src = ev.target.result;
      preview.style.display = "block";
    };
    reader.readAsDataURL(file);
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

})();
