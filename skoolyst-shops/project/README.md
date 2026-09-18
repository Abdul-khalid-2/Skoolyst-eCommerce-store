# Skoolyst Stores — Frontend UI Prototype

A polished, production-quality frontend prototype for **Skoolyst Stores**, a Pakistan-focused education marketplace connecting schools, parents, students, teachers, and school-related businesses.

## Technology Stack

This project uses **only**:

- HTML5
- CSS3
- Vanilla JavaScript
- Bootstrap 5 (via CDN)
- Bootstrap Icons (via CDN)

No frameworks, no build tools, no packages, no dependencies beyond the two CDN links.

## Project Structure

```
/
├── index.html              # Homepage — hero, categories, featured stores, popular products
├── stores.html             # Store discovery — filterable store grid with pagination
├── store.html              # Store profile — tabs for home, products, about, reviews
├── products.html          # Product browsing — filterable product grid
├── product.html           # Product detail — gallery, tabs, store info, related products
├── cart.html              # Shopping cart — quantity controls, order summary, empty state
├── checkout.html          # Checkout — customer info, delivery, payment, order summary
├── login.html             # Customer login — split-screen auth layout
├── register.html          # Customer registration — split-screen auth layout
│
├── dashboard/
│   ├── index.html          # Dashboard overview — stats, sales chart, recent orders
│   ├── products.html       # Product management — table with actions
│   ├── add-product.html    # Add/edit product form — all fields
│   ├── store-profile.html  # Store profile management — info, contact, location
│   ├── orders.html         # Orders management — table + detail modal with timeline
│   ├── customers.html      # Customer list — table + detail modal
│   ├── analytics.html      # Analytics — charts, top products, revenue summary
│   └── settings.html        # Settings — general, store, notifications, security tabs
│
├── assets/
│   ├── css/
│   │   └── style.css       # Global design system — colors, typography, components
│   ├── js/
│   │   └── app.js          # Shared JS — cart, toasts, filters, sidebar, validation
│   └── images/             # (for future local images)
│
└── README.md
```

## Features

### Customer Marketplace
- Homepage with hero, category cards, featured stores, popular products, and CTA
- Store discovery with filter sidebar (search, location, category, type, rating, verified)
- Store profile with tabs (Home, Products, About, Reviews) and rating breakdown
- Product browsing with filters (search, category, store, price range, rating, availability)
- Product detail with image gallery, quantity selector, store card, tabs, related products
- Shopping cart with localStorage persistence, quantity controls, order summary, empty state
- Multi-section checkout with customer info, delivery address, delivery method, payment method
- Login and register pages with split-screen layout

### Store Owner Dashboard
- Dashboard overview with stat cards, pure CSS bar chart, top products, recent orders table
- Product management table with search, filters, status badges, action dropdowns
- Add product form with basic info, pricing, inventory, media upload UI, status
- Store profile management with logo, cover, contact, location, business info
- Orders table with detail modal showing customer, products, payment, status timeline
- Customer list with detail modal showing order history
- Analytics with stat cards, sales chart, donut chart, top products, revenue summary
- Settings with tabbed forms (General, Store, Notifications, Security)

### Interactions (Vanilla JS)
- Add to cart with toast notifications
- Cart persistence via localStorage
- Quantity selectors
- Mobile navigation (offcanvas)
- Dashboard sidebar toggle (mobile)
- Filter sidebar toggle (mobile)
- Product gallery thumbnail switching
- Follow/store save button
- Form validation
- Tab persistence via URL parameters

## Design

- **Brand color**: Dark navy (#0f2a47) as primary
- **Accent**: Warm amber (#f59e0b) for CTAs and highlights
- **Typography**: Segoe UI / Inter / system fonts
- **Spacing**: 8px-based system
- **Radius**: 0.625rem standard, 1rem for large elements
- **Responsive**: Mobile-first with breakpoints at 575px, 767px, 991px, 1199px

## Running the Project

Simply open any HTML file in a browser, or serve the directory from any basic web server (PHP, Apache, Python, etc.).

## Backend Integration Notes

The UI is structured for easy PHP backend connection:
- Product cards use `data-*` attributes for product info
- Forms use meaningful `name` attributes on all fields
- Tables have predictable, consistent structure
- Buttons/actions have identifiable CSS classes
- Cart uses localStorage but can be swapped for API calls
- All prices use "Rs." prefix for Pakistani Rupees

## Notes

- All data is dummy/prototype data
- No real authentication, payments, or API calls
- Images are loaded from Pexels (license-free stock photos)
- No console errors expected
