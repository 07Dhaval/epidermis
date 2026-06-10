-- Epidermis Skin Clinic Database Schema
-- MySQL 8.0+

CREATE DATABASE IF NOT EXISTS epidermis_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE epidermis_db;

-- Services table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    icon VARCHAR(50) DEFAULT 'circle',
    short_description TEXT,
    full_description TEXT,
    image_url VARCHAR(255),
    is_popular TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(100) NOT NULL,
    service_id INT,
    quote TEXT NOT NULL,
    course_duration VARCHAR(50),
    rating DECIMAL(2,1) DEFAULT 5.0,
    avatar_url VARCHAR(255),
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);

-- Clinic updates / news
CREATE TABLE IF NOT EXISTS clinic_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    excerpt TEXT,
    content LONGTEXT,
    date_published DATE,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- FAQ table
CREATE TABLE IF NOT EXISTS faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1
);

-- Consultations / bookings
CREATE TABLE IF NOT EXISTS consultations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(20),
    service_id INT,
    preferred_date DATE,
    message TEXT,
    status ENUM('pending','confirmed','completed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);

-- Instagram / social gallery
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    instagram_url VARCHAR(255),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed: Services
INSERT INTO services (name, slug, icon, short_description, is_popular) VALUES
('Acne Treatment', 'acne-treatment', 'circle-dot', 'Advanced acne clearing therapies for clearer skin.', 1),
('Laser Skin Resurfacing', 'laser-skin-resurfacing', 'zap', 'Precision laser treatments to rejuvenate skin texture.', 1),
('Tattoo Removal', 'tattoo-removal', 'pencil-line', 'Safe and effective laser tattoo fading and removal.', 0),
('Body Massage', 'body-massage', 'wave', 'Relaxing full-body treatments for wellness and skin health.', 0),
('Chemical Peel', 'chemical-peel', 'sparkles', 'Medical-grade peels for renewed radiant skin.', 1),
('Laser Hair Removal', 'laser-hair-removal', 'scan-line', 'Long-lasting smooth skin with precision laser hair removal.', 0),
('Mole and Skin Tag Removal', 'mole-skin-tag-removal', 'slash', 'Quick and safe removal of moles and skin tags.', 0),
('Eye Patch Treatment', 'eye-patch-treatment', 'eye', 'Hydrating and de-puffing under-eye patch therapies.', 0);

-- Seed: Testimonials
INSERT INTO testimonials (patient_name, service_id, quote, course_duration, rating, is_featured) VALUES
('John A.', 1, 'I struggled with acne for many years, and nothing seemed to work until I came to Epidermis. Their personalized treatment plan gave me clear, glowing skin, and for the first time, I finally feel truly confident in my own skin!', '3 weeks', 4.9, 1),
('Josephina L.', 2, 'The team at Epidermis is absolutely amazing. They explained every step of my laser treatment, answered all my questions thoroughly, and made me feel completely at ease. My skin has never looked this flawless!', '1 week', 5.0, 1),
('Emily H.', 5, 'I tried their chemical peel, and my skin felt so refreshed, rejuvenated, and incredibly smooth almost right away. The results were so impressive that it\'s now become an essential part of my regular skincare routine!', '2 sessions', 4.8, 1);

-- Seed: Clinic Updates
INSERT INTO clinic_updates (title, slug, excerpt, date_published) VALUES
('Skin Allergy Specialist', 'skin-allergy-specialist', 'Certified expertise in diagnosing and effectively treating a wide range of skin allergies to improve outcomes.', '2023-10-01'),
('Certified in Dermoscopy', 'certified-in-dermoscopy', 'Expertise in diagnosing various skin conditions and abnormalities using advanced dermoscopy techniques.', '2023-07-01'),
('New Chemical Peel Protocols', 'new-chemical-peel-protocols', 'We have introduced new medical-grade peel treatments for faster results and minimal downtime.', '2024-01-15'),
('Expanded Laser Services', 'expanded-laser-services', 'Our clinic now offers expanded laser treatments including fractional CO2 resurfacing.', '2024-03-01');

-- Seed: FAQs
INSERT INTO faqs (question, answer, display_order) VALUES
('What types of skin conditions can your clinic help with, and are your treatments customized?', 'We treat a wide range of skin conditions including acne, hyperpigmentation, fine lines, rosacea, eczema, and more. Every treatment plan is fully customized based on your skin type, concerns, and goals after a thorough consultation with our specialists.', 1),
('How do I book an appointment at your clinic, and what is the process?', 'You can book a consultation directly through our website using the Book a Consultation button, by calling our clinic, or by visiting us in person. We will confirm your appointment within 24 hours and send you preparation instructions.', 2),
('Do I need to follow any special instructions to prepare for my treatment?', 'Preparation varies by treatment. For laser treatments, avoid sun exposure for at least 2 weeks prior. For chemical peels, stop retinol use 5–7 days before. Our team will provide you with complete pre-treatment guidelines after booking.', 3),
('Are the treatments safe for people with sensitive or reactive skin types?', 'Absolutely. We specialize in treating sensitive skin and always perform a patch test before any treatment. Our dermatologists tailor protocols to minimize irritation and maximize results for reactive skin types.', 4),
('How long does it usually take to see noticeable results?', 'Results vary by treatment and individual skin. Many clients see improvement after their first session, while others may need 3–6 sessions for optimal results. We will set realistic expectations during your initial consultation.', 5);

-- Seed: Gallery
INSERT INTO gallery (image_url, caption, display_order) VALUES
('https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?w=600', 'Gua sha facial tool', 1),
('https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=600', 'Skincare routine', 2),
('https://images.unsplash.com/photo-1552693673-1bf958298935?w=600', 'Glowing skin', 3),
('https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?w=600', 'Serum application', 4),
('https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=600', 'Happy after treatment', 5),
('https://images.unsplash.com/photo-1576426863848-c21f53c60b19?w=600', 'Face mask treatment', 6);
