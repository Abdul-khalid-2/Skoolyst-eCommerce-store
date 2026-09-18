# Skoolyst Unified Design System
**Version 1.0 — Audit Date: 2026-09-12**
**Status: Reference Document — Audit Only, No Implementation**

---

## Table of Contents

1. [Existing Design Comparison (Per Repo)](#a-existing-design-comparison)
2. [Proposed Unified Design System](#b-proposed-unified-skoolyst-design-system)
   - [Color System](#1-color-system)
   - [Typography](#2-typography)
   - [Buttons](#3-buttons)
   - [Cards](#4-cards)
   - [Forms & Inputs](#5-forms--inputs)
   - [Tables](#6-tables)
   - [Navigation & Header](#7-navigation--header)
   - [Sidebar](#8-sidebar)
   - [Icons](#9-icons)
   - [Spacing & Layout](#10-spacing--layout)
   - [Shadows & Elevation](#11-shadows--elevation)
   - [Border Radius Scale](#12-border-radius-scale)
   - [Badges & Status Indicators](#13-badges--status-indicators)
   - [Admin Dashboard Style](#14-admin-dashboard-style)
   - [Responsive Rules](#15-responsive-rules)
3. [Conflicts & Risks](#c-conflicts--risks)

---

## A. Existing Design Comparison

### 1. skoolyst/ — Main School Directory Website

| Property | Current Value |
|---|---|
| **Tech Stack** | Laravel 12, Tailwind CSS 3.1, Bootstrap 5.3 (loaded via CDN in blade files, **not** an npm dependency — `package.json` has no Bootstrap package), Vite 7, Alpine.js 3.4 |
| **Primary Color** | `#4361ee` (bright blue, gradient with `#38b000` green) |
| **Background** | `#f8f9fa` |
| **Text** | `#1a1a1a` (heading), `#666666` (muted) |
| **Border** | `#e0e0e0` |
| **Font** | Inter (`@fontsource`) **and** Figtree (`@fontsource`, used in `layouts/guest.blade.php` and `layoutsd/*.blade.php`) — two heading/body font families active side by side |
| **Button Radius** | 8px (default), 50px (auth/hero buttons — pill shape) |
| **Button Weight** | 600 |
| **Button Hover** | translateY(-2px) + shadow `0 4px 15px rgba(67,97,238,0.4)` |
| **Card Radius** | 12px on public marketing cards; dashboard cards vary per blade file (e.g. `dashboard/index.blade.php` uses ~15px with its own shadow values) — no single shared card style |
| **Card Shadow** | `0 4px 12px rgba(0,0,0,0.08)` (public); dashboard shadows vary per page |
| **Card Hover** | translateY(-8px) — aggressive lift |
| **Navbar BG** | White, shadow `0 2px 10px rgba(0,0,0,0.1)` |
| **Navbar Height** | 70px |
| **Dashboard Sidebar** | Gradient `#1e293b → #334155`, width 280px (confirmed in `resources/views/dashboard/index.blade.php`) |
| **Dashboard Header** | White, height 70px |
| **Icons** | Font Awesome 6.4.0 |
| **Container** | 1200px max-width |
| **CSS Variables** | Only `--sidebar-width`, `--header-height` |
| **CSS Architecture** | No central stylesheet — most styling lives in per-blade-file inline `<style>` blocks, so the same component (e.g. cards) is redefined with slightly different values on different pages |

**Key Inconsistencies:**
- Uses BOTH Tailwind AND Bootstrap — potential class conflicts, and Bootstrap is pulled in ad hoc via CDN rather than managed as a dependency
- Two font families in play (Inter + Figtree) with no documented rule for when each applies
- Gradient primary (blue→green) does not appear in any other repo
- Pill buttons (50px radius) clash with the 8px standard used elsewhere
- Dashboard sidebar uses Tailwind Slate palette while public site uses custom colors
- No comprehensive CSS variable system — colors are mostly hardcoded
- Styling is scattered across inline `<style>` blocks per blade file instead of a shared CSS source, so components like cards drift in radius/shadow from page to page

---

### 2. skoolyst-blog-management-system/

> ⚠️ **Note (post-verification):** `resources/css/app.css` in this repo already carries the header comment *"Skoolyst Unified Design System — Blog Module — Aligned with SKOOLYST-DESIGN-SYSTEM.md v1.0"* and defines the **proposed** unified variable names (`--skoolyst-primary`, `--skoolyst-accent`, `--skoolyst-shadow-md`, etc. — see [Section B](#1-color-system)) directly, keeping the legacy names below only as backward-compat aliases. In other words, someone has already started implementing the unified system in this one repo, ahead of this document's own "audit only, no implementation" scope. Treat the values below as the **legacy baseline this repo migrated from**, and treat this repo as the reference implementation to check the unified variables against once Phase 2 rollout begins elsewhere.

| Property | Current/Legacy Value |
|---|---|
| **Tech Stack** | Custom PHP MVC, PHP 8.2+, no npm |
| **Primary Color** | `#0F4077` (navy blue) — now aliased to `--skoolyst-primary` |
| **Brand Dark** | `#0A0E2A` (very dark navy) |
| **Accent Cyan** | `#00D9FF` |
| **Accent Gold** | `#F4B942` |
| **Background** | `#F8FAFC` |
| **Surface** | `#FFFFFF` |
| **Text** | `#172033` (heading), `#64748B` (muted) |
| **Border** | `#E2E8F0` |
| **Font** | Inter, system-ui stack |
| **Button Radius** | 10px (via `--radius`) |
| **Button Weight** | 600 |
| **Button Hover** | opacity 0.9, translateY(1px) on active |
| **Card Radius** | 10px |
| **Card Shadow** | `0 4px 20px rgba(10,14,42,.08)` — now aliased to `--skoolyst-shadow-md` |
| **Navbar BG** | `#0A0E2A`, height 64px |
| **Sidebar BG** | `#0A0E2A`, width 240px |
| **Sidebar Text** | `#CBD5E1` |
| **Icons** | Not explicitly defined (likely Font Awesome via CDN) |
| **Container** | 1200px max-width |
| **CSS Variables** | Legacy names (`--skoolyst-navy`, `--skoolyst-blue`, `--skoolyst-cyan`, `--skoolyst-gold`, `--radius`, `--shadow`, `--container`) kept as aliases on top of newly-added unified `--skoolyst-*` variables |

**Key Inconsistencies:**
- No icon library explicitly declared in CSS
- Button hover uses opacity rather than color/transform — different from skoolyst main
- Sidebar is narrower (240px) vs skoolyst main (280px)
- This repo has partially pre-adopted the unified naming convention while every other repo has not — migration order should account for this so the rollout doesn't clobber work already done here

---

### 3. skoolyst-quiz-system/

| Property | Current Value |
|---|---|
| **Tech Stack** | Custom PHP MVC, PHP 8.2+ |
| **Primary Color** | `#0F4077` (navy) |
| **Brand Dark** | `#0A0E2A` |
| **Accent Cyan** | `#00B8D4` (slightly muted cyan) |
| **Accent Gold** | `#F5A623` |
| **Background** | `#F5F7FA` |
| **Text** | `#1E293B`, muted `#64748B`, faint `#94A3B8` |
| **Border** | `#E2E8F0` (standard), `#CBD5E1` (dark) |
| **Font** | Segoe UI, system-ui stack (diverges from Inter) |
| **Button Radius** | 6px (small `--sk-radius-sm`), 10px (standard `--sk-radius`) |
| **Button Weight** | 600–700 |
| **Card Radius** | 10px |
| **Card Shadow** | `0 4px 16px rgba(10,14,42,0.10)` |
| **Card Hover** | translateY(-2px) + increased shadow |
| **Navbar BG** | White, border-bottom, shadow |
| **Status Colors** | Success `#16A34A`, Warning `#F59E0B`, Error `#DC2626`, Info `#0EA5E9` |
| **Icons** | Not specified, likely Font Awesome |
| **Container** | 1200px max-width |
| **CSS Variables** | Comprehensive: `--sk-dark-navy`, `--sk-navy`, `--sk-navy-light`, `--sk-cyan`, `--sk-radius`, `--sk-radius-sm`, `--sk-shadow-sm/md/lg`, `--sk-font`, `--sk-transition` |

**Key Inconsistencies:**
- Uses Segoe UI instead of Inter (only repo that does this)
- Accent cyan is `#00B8D4` — darker than blog's `#00D9FF`
- Adds a 3-level shadow scale which no other repo has
- MCQ option cards are a unique component pattern not present elsewhere

---

### 4. skoolyst-docs/

| Property | Current Value |
|---|---|
| **Tech Stack** | Static HTML/CSS, no build tool |
| **Primary Navy** | `#0f2540` (Navy 800) |
| **Brand Dark** | `#0a1628` (Navy 900) |
| **Accent Cyan** | `#06b6d4` (Cyan 500) |
| **Accent Gold** | `#f59e0b` (Gold 500) |
| **Background** | White body, `#eef4fa` (Navy 50) for sidebar |
| **Text** | `#1d3d63` (Navy 600) heading, standard body |
| **Font** | Inter + JetBrains Mono (for code blocks) |
| **Heading Scale** | H1: 2.25rem, H2: 1.625rem, H3: 1.25rem, H4: 1.0625rem |
| **Button Radius** | 8px |
| **Button Weight** | 600 |
| **Card Radius** | 8–12px (scale: sm/md/lg/xl) |
| **Header Height** | 64px |
| **Header BG** | `#0a1628` (Navy 900, dark) |
| **Sidebar Width** | 280px |
| **TOC Width** | 240px |
| **Content Max Width** | 820px |
| **Line Height** | 1.6 |
| **Letter Spacing** | -0.02em (H1), -0.01em (H2) |
| **Spacing Scale** | 8px base, 10 steps (0.25rem → 5rem) |
| **Shadows** | 4-level scale: sm/md/lg/xl |
| **Icons** | SVG-based (inline) |
| **Container** | Content 820px, outer 1200px |

**Key Inconsistencies:**
- Docs site uses a content max-width of 820px, which differs from app container patterns
- Monospace font (JetBrains Mono) is unique to this repo
- Most thorough design token system of all repos
- Dark header matches blog/admin pattern; body is light — creates the most contrast

---

### 5. skoolyst-advertisement/

| Property | Current Value |
|---|---|
| **Tech Stack** | Custom PHP, PHP 8.2+ |
| **Primary Color** | `#0f4077` (navy) |
| **Secondary** | `#4361ee` (bright blue — matches skoolyst main's primary) |
| **Admin Accent** | `#7c3aed` (purple — unique to this repo) |
| **Background** | `#f8fafb` |
| **Text** | `#1e293b`, muted `#64748b`, faint `#94a3b8` |
| **Border** | `#e2e8f0` |
| **Font** | Inter + JetBrains Mono |
| **Button Radius** | 8px (SM), 12px (MD), 18px (LG) — 3-tier system |
| **Button Weight** | 600 |
| **Card Radius** | 12px |
| **Card Shadow** | `0 1px 2px rgba(15,23,42,0.04), 0 8px 24px rgba(15,23,42,0.06)` (double-layer) |
| **Sidebar BG** | `#0b1730` (custom dark, not `#0A0E2A`) |
| **Sidebar Width** | 264px (collapsed: 84px) |
| **Sidebar Text** | `rgba(255,255,255,0.68)` |
| **Topbar Height** | 68px |
| **Status Colors** | Success `#0d9488` (teal, not standard green), Warning `#d97706`, Danger `#dc2626` |
| **Icons** | Not specified |

**Key Inconsistencies:**
- Purple admin accent (`#7c3aed`) appears in no other repo
- Success color `#0d9488` is teal rather than the standard green used elsewhere
- Double-layer card shadow pattern is unique
- Collapsible sidebar (264px/84px) — only repo with this behavior
- 3-tier button radius scale adds unnecessary variation

---

### 6. skoolyst-teachers/

| Property | Current Value |
|---|---|
| **Tech Stack** | Custom PHP/HTML, PHP 8.2+ |
| **Primary Color** | `#0A2D52` (medium navy) |
| **Primary Light** | `#123f6e` |
| **Primary Soft** | `#eef3f8` |
| **Background** | `#f6f8fb` |
| **Text** | `#1c2b3a`, muted `#63758a` |
| **Border** | `#e4e9f0` |
| **Font** | Poppins, Segoe UI stack (unique — only repo using Poppins) |
| **Button Radius** | 40px (pill buttons everywhere) |
| **Button Weight** | 700 |
| **Button Font Size** | 18px |
| **Button Padding** | 12px 35px |
| **Button Hover** | scale(1.05) |
| **Card Radius** | 12px (via `--radius`) |
| **Card Shadow** | `0 6px 24px rgba(10,45,82,0.08)` |
| **Card Hover Shadow** | `0 12px 32px rgba(10,45,82,0.14)` |
| **Header BG** | White, height 68px |
| **Status Colors** | Success `#1f9d55`, Danger `#d64545` |
| **Dark Mode** | Full dark mode with `#151515`/`#222222` backgrounds |
| **Skin Colors** | 5 switchable skin colors (red, orange, green, etc.) |
| **Hero Section** | Dark primary gradient, white text, 38px H1, full-bleed |
| **Container** | 1180px, padding 0 20px |
| **Section Padding** | 60px top/bottom |
| **Icons** | Not specified |

**Key Inconsistencies:**
- Only repo using Poppins font
- Pill buttons (40px radius) with 700 weight/18px size — most aggressive button style
- Only repo with dark mode + skin switcher
- Largest button font size (18px vs 14-16px elsewhere)
- Success color diverges from standard
- No CSS variable for primary color consistency across skins

---

### Cross-Repo Inconsistency Summary

| Concern | Detail |
|---|---|
| **Font family** | 4 different fonts: Inter (skoolyst, blog, docs, advert), Segoe UI (quiz), Poppins (teachers), mixed (skoolyst uses both Tailwind defaults + Inter) |
| **Primary blue** | 4 variants: `#4361ee`, `#0F4077`, `#0A2D52`, `#0b1730` |
| **Cyan accent** | 3 variants: `#00D9FF`, `#00B8D4`, `#06b6d4` |
| **Gold accent** | 3 variants: `#F4B942`, `#F5A623`, `#f59e0b` |
| **Button radius** | Ranges from 6px to 50px — no consistency |
| **Button weight** | 600 (most) vs 700 (teachers) |
| **Card shadow** | 6 different shadow values |
| **Sidebar width** | 240px / 264px / 280px |
| **Header height** | 64px / 68px / 70px |
| **Success green** | 3 variants: `#16A34A`, `#1f9d55`, `#0d9488` (teal) |
| **Card hover** | translateY(-2px) vs (-8px) vs scale(1.05) |
| **Framework conflict** | skoolyst uses Tailwind + Bootstrap simultaneously |

---

## B. Proposed Unified Skoolyst Design System

### 1. Color System

All colors are defined as CSS custom properties. Use these names across every repo.

#### Core Brand Colors

| Variable | Hex | Role |
|---|---|---|
| `--skoolyst-primary` | `#0F4077` | Primary action color (navy blue) — buttons, links, active states |
| `--skoolyst-primary-dark` | `#0A2D52` | Hover state for primary, dark accents |
| `--skoolyst-primary-light` | `#1a5a9e` | Lighter primary for soft backgrounds, chips |
| `--skoolyst-primary-soft` | `#EEF3F8` | Very light primary tint for tag/chip backgrounds |
| `--skoolyst-brand-dark` | `#0A0E2A` | Sidebars, dark headers, brand identity dark |
| `--skoolyst-secondary` | `#00C4D9` | Accent cyan — highlights, active indicators, links on dark backgrounds |
| `--skoolyst-secondary-dark` | `#0097B0` | Hover state for cyan |
| `--skoolyst-accent` | `#F4B942` | Gold — secondary accents, call-to-action highlights, badges |
| `--skoolyst-accent-dark` | `#D4961A` | Gold hover state |

#### Neutral Colors

| Variable | Hex | Role |
|---|---|---|
| `--skoolyst-background` | `#F5F7FA` | Page background |
| `--skoolyst-surface` | `#FFFFFF` | Card, modal, panel background |
| `--skoolyst-surface-alt` | `#F0F4F8` | Zebra rows, secondary surface, hover background |
| `--skoolyst-text` | `#1E293B` | Primary body text, headings |
| `--skoolyst-text-heading` | `#0A2D52` | H1–H3 heading text |
| `--skoolyst-muted` | `#64748B` | Secondary/muted text, labels, captions |
| `--skoolyst-faint` | `#94A3B8` | Placeholder text, disabled labels |
| `--skoolyst-border` | `#E2E8F0` | Default border for cards, inputs, dividers |
| `--skoolyst-border-dark` | `#CBD5E1` | Stronger border for tables, focused separators |

#### Status / Functional Colors (Do Not Modify)

These carry semantic meaning and must remain consistent across every repo.

| Variable | Hex | Role |
|---|---|---|
| `--skoolyst-success` | `#16A34A` | Success states, active, passed |
| `--skoolyst-success-bg` | `#DCFCE7` | Success background tint |
| `--skoolyst-warning` | `#F59E0B` | Warning states, pending, caution |
| `--skoolyst-warning-bg` | `#FEF3C7` | Warning background tint |
| `--skoolyst-danger` | `#DC2626` | Error states, delete, failed, critical |
| `--skoolyst-danger-bg` | `#FEE2E2` | Danger background tint |
| `--skoolyst-info` | `#0EA5E9` | Informational states, tips, in-progress |
| `--skoolyst-info-bg` | `#E0F2FE` | Info background tint |

#### Complete CSS Variables Block

```css
:root {
  /* Brand */
  --skoolyst-primary:        #0F4077;
  --skoolyst-primary-dark:   #0A2D52;
  --skoolyst-primary-light:  #1a5a9e;
  --skoolyst-primary-soft:   #EEF3F8;
  --skoolyst-brand-dark:     #0A0E2A;
  --skoolyst-secondary:      #00C4D9;
  --skoolyst-secondary-dark: #0097B0;
  --skoolyst-accent:         #F4B942;
  --skoolyst-accent-dark:    #D4961A;

  /* Neutrals */
  --skoolyst-background:     #F5F7FA;
  --skoolyst-surface:        #FFFFFF;
  --skoolyst-surface-alt:    #F0F4F8;
  --skoolyst-text:           #1E293B;
  --skoolyst-text-heading:   #0A2D52;
  --skoolyst-muted:          #64748B;
  --skoolyst-faint:          #94A3B8;
  --skoolyst-border:         #E2E8F0;
  --skoolyst-border-dark:    #CBD5E1;

  /* Status */
  --skoolyst-success:        #16A34A;
  --skoolyst-success-bg:     #DCFCE7;
  --skoolyst-warning:        #F59E0B;
  --skoolyst-warning-bg:     #FEF3C7;
  --skoolyst-danger:         #DC2626;
  --skoolyst-danger-bg:      #FEE2E2;
  --skoolyst-info:           #0EA5E9;
  --skoolyst-info-bg:        #E0F2FE;
}
```

---

### 2. Typography

#### Font Family

**Primary font:** `Inter`
**Fallback stack:** `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif`
**Monospace (code/data only):** `"JetBrains Mono", "Fira Code", "Courier New", monospace`

**Rationale:** Inter is already used in 4 of 6 repos. It has excellent legibility at small sizes (critical for tables and form labels) and a wide weight range that supports both the public-facing marketing pages and dense admin dashboards.

```css
:root {
  --skoolyst-font:  Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
                    "Helvetica Neue", Arial, sans-serif;
  --skoolyst-font-mono: "JetBrains Mono", "Fira Code", "Courier New", monospace;
}

body {
  font-family: var(--skoolyst-font);
  font-size: 15px;
  line-height: 1.6;
  color: var(--skoolyst-text);
}
```

#### Heading Scale

| Element | Font Size | Weight | Line Height | Letter Spacing | Color |
|---|---|---|---|---|---|
| `h1` | 2.25rem (36px) | 700 | 1.25 | -0.02em | `--skoolyst-text-heading` |
| `h2` | 1.75rem (28px) | 700 | 1.3 | -0.01em | `--skoolyst-text-heading` |
| `h3` | 1.375rem (22px) | 600 | 1.35 | 0 | `--skoolyst-text-heading` |
| `h4` | 1.125rem (18px) | 600 | 1.4 | 0 | `--skoolyst-text` |
| `h5` | 1rem (16px) | 600 | 1.5 | 0 | `--skoolyst-text` |
| `h6` | 0.875rem (14px) | 600 | 1.5 | 0 | `--skoolyst-muted` |

#### Body & UI Text

| Use | Font Size | Weight | Color |
|---|---|---|---|
| Body text | 0.9375rem (15px) | 400 | `--skoolyst-text` |
| Small / caption | 0.8125rem (13px) | 400 | `--skoolyst-muted` |
| Label (form) | 0.875rem (14px) | 600 | `--skoolyst-text` |
| Table cell | 0.875rem (14px) | 400 | `--skoolyst-text` |
| Table header | 0.75rem (12px) | 600 | `--skoolyst-muted` |
| Button | 0.875rem (14px) | 600 | (inherits from button variant) |
| Navigation | 0.875rem (14px) | 500 | `--skoolyst-text` |
| Badge / tag | 0.75rem (12px) | 600 | (inherits from badge variant) |
| Code / mono | 0.875rem (14px) | 400 | `--skoolyst-text` |

---

### 3. Buttons

#### Radius & Sizing

```css
:root {
  --skoolyst-btn-radius: 8px;     /* standard */
  --skoolyst-btn-radius-sm: 6px;  /* compact / table inline */
  --skoolyst-btn-radius-lg: 10px; /* hero CTA / prominent actions only */
}
```

**No pill buttons (border-radius: 40–50px) in the unified system.** The teachers repo's pill style is a product-level design choice for that marketing page and should stay scoped to that repo's public hero/CTA section only — it must not propagate to admin panels or other repos.

#### Button Variants

| Variant | Background | Border | Text | Usage |
|---|---|---|---|---|
| `.btn-primary` | `--skoolyst-primary` | none | white | Main CTA, form submit, primary action |
| `.btn-secondary` | `--skoolyst-secondary` | none | `--skoolyst-brand-dark` | Secondary CTA, accent actions |
| `.btn-outline` | transparent | 1.5px `--skoolyst-primary` | `--skoolyst-primary` | Secondary actions alongside primary |
| `.btn-outline-muted` | transparent | 1.5px `--skoolyst-border` | `--skoolyst-text` | Cancel, neutral actions |
| `.btn-danger` | `--skoolyst-danger` | none | white | Delete, destructive actions |
| `.btn-success` | `--skoolyst-success` | none | white | Confirm, approve actions |
| `.btn-ghost` | transparent | none | `--skoolyst-primary` | Link-like actions, nav items |
| `.btn-sm` | (modifier) | — | 0.8125rem font | Table inline, compact areas |
| `.btn-icon` | transparent | none | `--skoolyst-muted` | Icon-only actions, toolbar |

#### Button CSS Reference

```css
/* Base */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.6rem 1.25rem;
  font-size: 0.875rem;
  font-weight: 600;
  font-family: var(--skoolyst-font);
  line-height: 1;
  border-radius: var(--skoolyst-btn-radius);
  border: 1.5px solid transparent;
  cursor: pointer;
  text-decoration: none;
  transition: background 0.18s ease, border-color 0.18s ease,
              box-shadow 0.18s ease, transform 0.18s ease;
  white-space: nowrap;
  user-select: none;
}

.btn:hover   { transform: translateY(-1px); }
.btn:active  { transform: translateY(0);    }
.btn:focus-visible {
  outline: 2px solid var(--skoolyst-primary);
  outline-offset: 2px;
}
.btn:disabled,
.btn[aria-disabled="true"] {
  opacity: 0.5;
  cursor: not-allowed;
  transform: none;
}

/* Variants */
.btn-primary {
  background: var(--skoolyst-primary);
  color: #fff;
}
.btn-primary:hover { background: var(--skoolyst-primary-dark); }

.btn-secondary {
  background: var(--skoolyst-secondary);
  color: var(--skoolyst-brand-dark);
}
.btn-secondary:hover { background: var(--skoolyst-secondary-dark); color: #fff; }

.btn-outline {
  background: transparent;
  border-color: var(--skoolyst-primary);
  color: var(--skoolyst-primary);
}
.btn-outline:hover {
  background: var(--skoolyst-primary);
  color: #fff;
}

.btn-danger {
  background: var(--skoolyst-danger);
  color: #fff;
}
.btn-danger:hover { background: #b91c1c; }

/* Sizes */
.btn-sm {
  padding: 0.35rem 0.75rem;
  font-size: 0.8125rem;
  border-radius: var(--skoolyst-btn-radius-sm);
}
.btn-lg {
  padding: 0.8rem 1.75rem;
  font-size: 1rem;
  border-radius: var(--skoolyst-btn-radius-lg);
}
.btn-icon {
  padding: 0.5rem;
  border-radius: 6px;
  color: var(--skoolyst-muted);
}
.btn-icon:hover {
  background: var(--skoolyst-surface-alt);
  color: var(--skoolyst-text);
}
```

---

### 4. Cards

Cards can differ in content layout by functionality — a quiz card looks different from a school listing card. What must be consistent is the container styling.

#### Standard Card

```css
:root {
  --skoolyst-card-radius:  10px;
  --skoolyst-card-shadow:  0 1px 3px rgba(10, 14, 42, 0.05),
                           0 4px 16px rgba(10, 14, 42, 0.08);
  --skoolyst-card-shadow-hover: 0 4px 8px rgba(10, 14, 42, 0.06),
                                0 12px 28px rgba(10, 14, 42, 0.12);
}

.card {
  background: var(--skoolyst-surface);
  border: 1px solid var(--skoolyst-border);
  border-radius: var(--skoolyst-card-radius);
  box-shadow: var(--skoolyst-card-shadow);
  transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.card:hover {
  box-shadow: var(--skoolyst-card-shadow-hover);
  transform: translateY(-2px);  /* subtle — not the -8px seen in skoolyst main */
}

.card-header,
.card-body,
.card-footer {
  padding: 1.25rem 1.5rem;
}
.card-header {
  border-bottom: 1px solid var(--skoolyst-border);
  font-weight: 600;
  font-size: 0.9375rem;
  color: var(--skoolyst-text-heading);
}
.card-footer {
  border-top: 1px solid var(--skoolyst-border);
  background: var(--skoolyst-surface-alt);
  border-radius: 0 0 var(--skoolyst-card-radius) var(--skoolyst-card-radius);
}
```

#### Stat / Dashboard Card

Used in admin dashboards for KPI numbers.

```css
.stat-card {
  background: var(--skoolyst-surface);
  border: 1px solid var(--skoolyst-border);
  border-radius: var(--skoolyst-card-radius);
  padding: 1.5rem;
  box-shadow: var(--skoolyst-card-shadow);
}
.stat-card .stat-label {
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: none;              /* no all-caps */
  color: var(--skoolyst-muted);
  margin-bottom: 0.5rem;
}
.stat-card .stat-value {
  font-size: 1.875rem;
  font-weight: 700;
  color: var(--skoolyst-text-heading);
  line-height: 1;
}
.stat-card .stat-change {
  font-size: 0.8125rem;
  margin-top: 0.375rem;
}
```

---

### 5. Forms & Inputs

```css
.form-group {
  margin-bottom: 1.25rem;
}
.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--skoolyst-text);
  margin-bottom: 0.375rem;
}
.form-control,
.form-select {
  width: 100%;
  padding: 0.625rem 0.875rem;
  font-size: 0.875rem;
  font-family: var(--skoolyst-font);
  color: var(--skoolyst-text);
  background: var(--skoolyst-surface);
  border: 1.5px solid var(--skoolyst-border);
  border-radius: 8px;
  line-height: 1.5;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
  outline: none;
}
.form-control::placeholder {
  color: var(--skoolyst-faint);
}
.form-control:focus,
.form-select:focus {
  border-color: var(--skoolyst-primary);
  box-shadow: 0 0 0 3px rgba(15, 64, 119, 0.12);
}
.form-control.is-invalid {
  border-color: var(--skoolyst-danger);
}
.form-control.is-invalid:focus {
  box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
}
.form-error {
  font-size: 0.8125rem;
  color: var(--skoolyst-danger);
  margin-top: 0.25rem;
}
.form-hint {
  font-size: 0.8125rem;
  color: var(--skoolyst-muted);
  margin-top: 0.25rem;
}
textarea.form-control {
  min-height: 120px;
  resize: vertical;
}
```

---

### 6. Tables

```css
.table-wrapper {
  overflow-x: auto;
  border: 1px solid var(--skoolyst-border);
  border-radius: var(--skoolyst-card-radius);
  background: var(--skoolyst-surface);
}
.table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.875rem;
}
.table thead th {
  padding: 0.75rem 1rem;
  text-align: left;
  font-size: 0.75rem;
  font-weight: 600;
  color: var(--skoolyst-muted);
  background: var(--skoolyst-surface-alt);
  border-bottom: 1px solid var(--skoolyst-border);
  white-space: nowrap;
}
.table tbody td {
  padding: 0.75rem 1rem;
  color: var(--skoolyst-text);
  border-bottom: 1px solid var(--skoolyst-border);
  vertical-align: middle;
}
.table tbody tr:last-child td {
  border-bottom: none;
}
.table tbody tr:hover td {
  background: var(--skoolyst-surface-alt);
}
```

---

### 7. Navigation & Header

#### Public Site Navbar (Light)

```css
.navbar {
  background: var(--skoolyst-surface);
  height: 64px;
  border-bottom: 1px solid var(--skoolyst-border);
  box-shadow: 0 1px 4px rgba(10, 14, 42, 0.06);
  position: sticky;
  top: 0;
  z-index: 1000;
}
.navbar-brand {
  font-size: 1.375rem;
  font-weight: 800;
  color: var(--skoolyst-primary);
  letter-spacing: -0.02em;
  text-decoration: none;
}
.nav-link {
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--skoolyst-text);
  padding: 0.375rem 0.75rem;
  border-radius: 6px;
  text-decoration: none;
  transition: color 0.15s, background 0.15s;
}
.nav-link:hover,
.nav-link.active {
  color: var(--skoolyst-primary);
  background: var(--skoolyst-primary-soft);
}
```

#### Admin Header (Dark)

```css
.admin-header {
  background: var(--skoolyst-brand-dark);
  height: 64px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.admin-header .navbar-brand {
  color: #fff;
}
.admin-header .nav-link {
  color: rgba(255,255,255,0.72);
}
.admin-header .nav-link:hover,
.admin-header .nav-link.active {
  color: #fff;
  background: rgba(255,255,255,0.08);
}
```

---

### 8. Sidebar

```css
:root {
  --skoolyst-sidebar-width: 260px;
  --skoolyst-header-height: 64px;
}

.sidebar {
  width: var(--skoolyst-sidebar-width);
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  background: var(--skoolyst-brand-dark);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  z-index: 900;
}
.sidebar-header {
  height: var(--skoolyst-header-height);
  padding: 0 1.25rem;
  display: flex;
  align-items: center;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  flex-shrink: 0;
}
.sidebar-brand {
  font-size: 1.125rem;
  font-weight: 700;
  color: #fff;
  letter-spacing: -0.01em;
}
.sidebar-nav {
  padding: 1rem 0.75rem;
  flex: 1;
}
.sidebar-item {
  padding: 0.5rem 0.75rem;
  border-radius: 8px;
  font-size: 0.875rem;
  font-weight: 500;
  color: rgba(255,255,255,0.68);
  display: flex;
  align-items: center;
  gap: 0.625rem;
  text-decoration: none;
  transition: background 0.15s, color 0.15s;
  margin-bottom: 2px;
}
.sidebar-item:hover {
  background: rgba(255,255,255,0.08);
  color: rgba(255,255,255,0.92);
}
.sidebar-item.active {
  background: rgba(255,255,255,0.1);
  color: #fff;
  font-weight: 600;
}
.sidebar-section-label {
  font-size: 0.6875rem;
  font-weight: 700;
  color: rgba(255,255,255,0.38);
  padding: 0.75rem 0.75rem 0.25rem;
  letter-spacing: 0.06em;
}
```

---

### 9. Icons

**Unified library:** Font Awesome 6 (Free tier, solid + regular + brands subsets)
- Existing repos already reference Font Awesome 6.4.0
- Where repos currently use inline SVG (docs, teachers), that is acceptable for custom brand icons only
- All functional UI icons (nav, actions, status) should use Font Awesome to ensure visual consistency

**Icon sizing:**

| Context | Size | Color |
|---|---|---|
| Sidebar navigation | 1rem (16px) | Inherits from sidebar-item |
| Button icon (with text) | 0.875rem (14px) | Inherits from button text |
| Button icon (icon-only) | 1rem (16px) | `--skoolyst-muted` |
| Table action icon | 0.875rem (14px) | `--skoolyst-muted` |
| Status icon (success/danger/etc.) | 1rem (16px) | Matching status color |
| Stat card icon | 1.25rem (20px) | `--skoolyst-primary` |
| Empty state icon | 2.5rem (40px) | `--skoolyst-faint` |

**Icon color rule:** Most icons use `--skoolyst-muted` or inherit from their container's text color. Status icons preserve their semantic color (success=`--skoolyst-success`, danger=`--skoolyst-danger`). Do not use gradients on icons; do not add shadows to icons.

---

### 10. Spacing & Layout

#### Spacing Scale (8px base)

| Token | Value | Typical use |
|---|---|---|
| `--space-1` | 0.25rem (4px) | Tight gaps between related inline elements |
| `--space-2` | 0.5rem (8px) | Icon-to-text gap, small padding |
| `--space-3` | 0.75rem (12px) | Button inner padding (vertical), form gap |
| `--space-4` | 1rem (16px) | Standard component internal padding |
| `--space-5` | 1.25rem (20px) | Card padding, form group gap |
| `--space-6` | 1.5rem (24px) | Section-level gaps, card grid gap |
| `--space-7` | 2rem (32px) | Section top/bottom padding |
| `--space-8` | 2.5rem (40px) | Page section spacing (interior) |
| `--space-9` | 3.5rem (56px) | Section spacing (between content blocks) |
| `--space-10` | 5rem (80px) | Hero / large section padding |

#### Layout

```css
:root {
  --skoolyst-container:       1200px;  /* public site max-width */
  --skoolyst-content-max:     860px;   /* docs/article content max-width */
  --skoolyst-sidebar-width:   260px;
  --skoolyst-header-height:   64px;
}

.container {
  max-width: var(--skoolyst-container);
  margin: 0 auto;
  padding: 0 1.25rem;
}

/* Admin layout */
.admin-layout {
  display: flex;
  min-height: 100vh;
}
.admin-main {
  margin-left: var(--skoolyst-sidebar-width);
  flex: 1;
  display: flex;
  flex-direction: column;
  min-width: 0;
}
.admin-content {
  padding: 1.75rem 2rem;
  flex: 1;
}
```

#### Grid

```css
/* Card grid — responsive auto-fill */
.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.25rem;
}

/* 2-column form layout */
.form-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.25rem;
}
@media (max-width: 640px) {
  .form-grid-2 { grid-template-columns: 1fr; }
}
```

---

### 11. Shadows & Elevation

Three-level elevation scale. Use the lowest level that achieves the visual separation needed.

| Variable | Value | Use |
|---|---|---|
| `--skoolyst-shadow-sm` | `0 1px 2px rgba(10,14,42,0.05)` | Subtle: inputs on focus, inline chips |
| `--skoolyst-shadow-md` | `0 1px 3px rgba(10,14,42,0.05), 0 4px 16px rgba(10,14,42,0.08)` | Cards, panels, dropdowns |
| `--skoolyst-shadow-lg` | `0 4px 8px rgba(10,14,42,0.06), 0 12px 28px rgba(10,14,42,0.12)` | Modals, card hover state, popovers |
| `--skoolyst-shadow-xl` | `0 8px 16px rgba(10,14,42,0.08), 0 24px 48px rgba(10,14,42,0.16)` | Sticky headers on scroll, full-screen modals |

No colored shadows, no gradient overlays used as decoration. Shadows encode elevation only.

---

### 12. Border Radius Scale

```css
:root {
  --skoolyst-radius-xs:  4px;   /* checkboxes, small chips, code tags */
  --skoolyst-radius-sm:  6px;   /* small buttons, compact inputs, table badges */
  --skoolyst-radius:    10px;   /* standard: cards, inputs, default buttons */
  --skoolyst-radius-lg: 12px;   /* large cards, modals, image containers */
  --skoolyst-radius-xl: 16px;   /* hero images, feature cards */
  --skoolyst-radius-full: 9999px; /* avatar circles, status dots, pills (use sparingly) */
}
```

---

### 13. Badges & Status Indicators

```css
.badge {
  display: inline-flex;
  align-items: center;
  padding: 0.2rem 0.6rem;
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: var(--skoolyst-radius-full);
  line-height: 1;
  white-space: nowrap;
}

.badge-success  { background: var(--skoolyst-success-bg);  color: #15803d; }
.badge-warning  { background: var(--skoolyst-warning-bg);  color: #b45309; }
.badge-danger   { background: var(--skoolyst-danger-bg);   color: #b91c1c; }
.badge-info     { background: var(--skoolyst-info-bg);     color: #0369a1; }
.badge-primary  { background: var(--skoolyst-primary-soft); color: var(--skoolyst-primary); }
.badge-muted    { background: var(--skoolyst-surface-alt); color: var(--skoolyst-muted); }
```

Status dot (for online/active indicators):
```css
.status-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  display: inline-block;
}
.status-dot-success { background: var(--skoolyst-success); }
.status-dot-warning { background: var(--skoolyst-warning); }
.status-dot-danger  { background: var(--skoolyst-danger);  }
.status-dot-muted   { background: var(--skoolyst-faint);   }
```

---

### 14. Admin Dashboard Style

The admin dashboard visual language is deliberately different from public marketing pages. It must be:
- **Simple:** No gradients on content elements, no decorative illustrations
- **Information-dense:** Smaller type scale, tighter spacing, scrollable tables
- **Professional:** Color used for data meaning, not decoration
- **Scannable:** Clear hierarchy, consistent alignment, no visual noise

**Rules for admin panels:**
1. Sidebar: Dark (`--skoolyst-brand-dark`), no gradients
2. Stat cards: White surface, no colorful icon backgrounds — the number is the visual
3. Status indicators: Use badge or status-dot components, not colored card borders
4. Action buttons in tables: Use `.btn-sm` + `.btn-ghost` or `.btn-icon`, not full `.btn-primary`
5. Page header (within admin): H2 + muted subtitle, no decorative elements
6. Navigation active state: Subtle highlight (`rgba(255,255,255,0.10)`), not a bold accent band
7. Icon color: `--skoolyst-muted` by default; only status-semantic icons use their status color

**What to simplify vs preserve:**
- REMOVE: Colorful gradient icon backgrounds on stat cards (seen in some repos)
- REMOVE: Heavy box shadows on individual table rows
- REMOVE: Multiple badge colors on a single row for non-status purposes
- PRESERVE: Success/warning/danger badge colors — these carry data meaning
- PRESERVE: Primary-colored buttons for primary CTAs (Add, Save, Publish)
- PRESERVE: Status dots / badges showing active/inactive/pending states

---

### 15. Responsive Rules

```css
/* Breakpoints */
:root {
  --bp-sm:  640px;
  --bp-md:  768px;
  --bp-lg:  1024px;
  --bp-xl:  1280px;
}

/* Mobile-first base rules */
@media (max-width: 1024px) {
  .admin-main {
    margin-left: 0;
  }
  .sidebar {
    transform: translateX(-100%);
    transition: transform 0.25s ease;
  }
  .sidebar.open {
    transform: translateX(0);
  }
}

@media (max-width: 768px) {
  .admin-content { padding: 1.25rem; }
  .card-grid { grid-template-columns: 1fr; }
  .container { padding: 0 1rem; }
  h1 { font-size: 1.75rem; }
  h2 { font-size: 1.375rem; }
}

@media (max-width: 640px) {
  .btn-lg { padding: 0.7rem 1.25rem; font-size: 0.9375rem; }
  .form-grid-2 { grid-template-columns: 1fr; }
  .table-wrapper { border-radius: 0; border-left: none; border-right: none; }
}
```

**Hard rules:**
- No horizontal overflow on any viewport — test at 320px, 375px, 768px, 1024px, 1440px
- Admin sidebar must collapse on tablet/mobile with a toggle button
- Tables must always be wrapped in a scrollable container at mobile
- Hero/feature sections that use gradient backgrounds: ensure text contrast ≥ 4.5:1
- Form labels always above fields (never inline placeholder-as-label) on all viewports

---

## C. Conflicts & Risks

### High Risk

| Repo | Risk | Detail |
|---|---|---|
| **skoolyst/** | Framework conflict | Uses Tailwind CSS 3 AND Bootstrap 5.3 simultaneously. Any design system CSS you add will be in a three-way specificity battle. Tailwind's utility classes will override custom CSS unpredictably. **Resolution before UI work:** Decide on one framework or scope custom variables very carefully with high specificity. |
| **skoolyst/** | Green gradient primary | The `#4361ee → #38b000` gradient is used as the primary brand color throughout. Replacing it with the unified `#0F4077` navy will cause a major visual shift that users may notice. This affects CTAs, hero sections, and the brand logo color. Requires explicit stakeholder sign-off. |
| **skoolyst-teachers/** | Skin color switcher | The JS-driven skin color system (5 color themes) overrides `--skin-color` CSS variable globally. Any new `--skoolyst-primary` usage in this repo may be silently overridden by the skin switcher at runtime. All new UI code in this repo must account for the skin variable OR the switcher must be phased out. |
| **skoolyst-teachers/** | Dark mode | Full dark mode is implemented via a separate CSS block. Every new component added to this repo must also include a dark mode variant, or it will break the dark theme. |
| **skoolyst-blog-management-system/** | Partial pre-adoption of unified variables | `resources/css/app.css` already defines `--skoolyst-primary`, `--skoolyst-accent`, `--skoolyst-shadow-md`, etc. ahead of the rest of the workspace, with legacy names kept only as aliases. Rolling out this document's final variable names/values elsewhere must reconcile with what's already live here — a mismatch (e.g. different hex values under the same variable name) would visually break this repo silently. Audit this file's exact values before finalizing Section B and treat any divergence as the tie-breaker input, not something to overwrite blindly. |

### Medium Risk

| Repo | Risk | Detail |
|---|---|---|
| **skoolyst-advertisement/** | Collapsible sidebar | The 264px↔84px sidebar toggle uses specific JS and CSS that depends on sidebar widths. Changing `--skoolyst-sidebar-width` to 260px needs to be coordinated with the collapse logic. Off by 4px will not break functionality but will misalign the collapsed icon positions. |
| **skoolyst-advertisement/** | Purple admin accent (`#7c3aed`) | This color is used for admin-specific UI elements (likely super-admin or platform-level actions). Removing it breaks visual distinction between admin and advertiser roles. It should be preserved as a role-specific color, scoped to that repo only, not added to the shared system. |
| **skoolyst-quiz/** | MCQ option cards | The selected/correct/incorrect states for quiz options use specific border colors and backgrounds tied to quiz logic (correct=green, incorrect=red). These are functional, not decorative. Do not touch these component styles during a design pass. |
| **skoolyst-quiz/** | Segoe UI font | Replacing Segoe UI with Inter will cause minor reflow — line lengths and heights will shift slightly. Any pixel-precise layout (e.g., quiz timer display, score overlay) should be visually re-verified after font change. |
| **skoolyst-docs/** | Content max-width | The 820px content width is intentional for readability in documentation. Do not apply the 1200px `--skoolyst-container` to the docs content area — only apply it to the outer shell/header. |

### Low Risk

| Repo | Risk | Detail |
|---|---|---|
| **skoolyst-blog/** | No icon library declared | FontAwesome is likely loaded via CDN in HTML templates not reflected in CSS. Verify before adding icon CSS assumptions. |
| **All repos** | CSS variable fallbacks | Older versions of PHP-rendered HTML might inline styles. When adding CSS variables, always add a static hex fallback: `color: #0F4077; color: var(--skoolyst-primary);` |
| **skoolyst-docs/** | Inline SVG icons | Docs uses inline SVGs that are tightly coupled to the page's color scheme. These will not inherit CSS variable color changes automatically — each SVG's `fill` or `stroke` attributes must be updated to use `currentColor` if you want variable-driven icon color. |
| **All admin dashboards** | Bootstrap 5 overrides | The blog, quiz, and advertisement repos extend Bootstrap 5 classes. When writing unified CSS, `--bs-*` variables conflict with `--skoolyst-*` variables. Override Bootstrap tokens explicitly where needed rather than fighting specificity. |

---

*This document is a design specification only. No files in any repository have been modified as part of producing this audit. Note that `skoolyst-blog-management-system/` already contains a partial, independently-made implementation of the proposed unified variables (see Section A.2 and the High Risk table above) — reconcile with it rather than treating this document as a greenfield spec for that repo. All implementation work should reference this document and respect each repo's existing tech stack and backend logic.*
