# Epidermis — Skin Clinic Website

A full-featured, production-grade skin clinic website with:
- ✅ Pixel-perfect design matching the original
- ✅ Floating font transmission animations
- ✅ Scroll-reveal & staggered animations
- ✅ PHP backend with PDO MySQL
- ✅ Complete MySQL schema with seed data
- ✅ AJAX consultation booking form
- ✅ FAQ accordion
- ✅ Responsive / mobile-first

---

## 📁 File Structure

```
epidermis/
├── index.html       ← Standalone (no server needed)
├── index.php        ← PHP version with dynamic DB data
├── php/
│   ├── config.php   ← DB credentials & helpers
│   ├── api.php      ← JSON API endpoints
│   └── book.php     ← Booking form handler
└── sql/
    └── epidermis.sql ← Full schema + seed data
```

---

## 🚀 Quick Start

### Option A — Static HTML (No server)
1. Open `index.html` directly in a browser.
2. All animations, interactions, and the booking modal work immediately.
3. Form submissions show a success message (demo mode, no DB write).

### Option B — Full PHP + MySQL Setup
1. **Create the database:**
   ```sql
   mysql -u root -p < sql/epidermis.sql
   ```
2. **Configure credentials** in `php/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_user');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'epidermis_db');
   ```
3. **Place the folder** inside your web root (e.g. `htdocs/epidermis/` or `/var/www/html/epidermis/`).
4. **Visit** `http://localhost/epidermis/` — the site will serve with live database data.

---

## 🗄️ Database Tables

| Table           | Description                        |
|-----------------|------------------------------------|
| `services`      | Clinic services & treatments       |
| `testimonials`  | Patient reviews with ratings       |
| `clinic_updates`| News / certifications / blog posts |
| `faqs`          | Frequently asked questions         |
| `consultations` | Booking form submissions           |
| `gallery`       | Instagram / social gallery images  |

---

## 🔌 PHP API Endpoints

`GET php/api.php?action=services`
`GET php/api.php?action=testimonials`
`GET php/api.php?action=updates`
`GET php/api.php?action=faqs`
`GET php/api.php?action=gallery`
`POST php/book.php` — Fields: full_name, email, phone, service_id, preferred_date, message

---

## 🎨 Design Notes

- **Colors:** Warm terracotta `#7b3b2a`, blush `#faf3ee`, muted rose `#f3e8df`
- **Fonts:** Cormorant Garamond (display) + DM Sans (body)
- **Animations:** Floating font particles, hero text reveal, scroll-triggered fade-in/slide-in, sun pulse, FAQ accordion
- **PHP version:** 8.0+ with PDO
- **MySQL:** 5.7+ / 8.0+
