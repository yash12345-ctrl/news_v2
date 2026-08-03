INSERT INTO categories (name_en, name_ur, created_at, updated_at) VALUES 
('testdata', 'testdata', NOW(), NOW()),
('ab', 'ab', NOW(), NOW()),
('et', 'et', NOW(), NOW()),
('quasi', 'quasi', NOW(), NOW());

INSERT INTO admins (first_name, last_name, email, password, status, role, created_at, updated_at) VALUES 
('Super', 'Admin', 'admin@akhbarmashriq.com', 'password', 1, 1, NOW(), NOW());

INSERT INTO articles (category_id, admin_id, title_en, title_ur, content_short_en, content_short_ur, content_en, content_ur, slug, image_url, image_sm_url, source, article_url, views, status, published_at, visible_in, created_at, updated_at) VALUES 
(1, 1, 'Breaking News: Global Markets Rally', 'بریکنگ نیوز', 'Short Content', 'Short Content UR', 'Long Content', 'Long Content UR', 'test-article-1', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&q=80&w=1200', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&q=80&w=800', 'Source', 'http://127.0.0.1:8000/articles/test-article-1', 1500, 2, NOW(), 3, NOW(), NOW()),
(2, 1, 'Tech Innovations in 2026', 'بریکنگ نیوز', 'Short Content', 'Short Content UR', 'Long Content', 'Long Content UR', 'test-article-2', 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=1200', 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=800', 'Source', 'http://127.0.0.1:8000/articles/test-article-2', 2000, 2, NOW(), 3, NOW(), NOW()),
(3, 1, 'Sports Championship Highlights', 'بریکنگ نیوز', 'Short Content', 'Short Content UR', 'Long Content', 'Long Content UR', 'test-article-3', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=1200', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=800', 'Source', 'http://127.0.0.1:8000/articles/test-article-3', 3000, 2, NOW(), 3, NOW(), NOW()),
(4, 1, 'Cultural Festival Celebrations', 'بریکنگ نیوز', 'Short Content', 'Short Content UR', 'Long Content', 'Long Content UR', 'test-article-4', 'https://images.unsplash.com/photo-1462275646964-a0e3386b89fa?auto=format&fit=crop&q=80&w=1200', 'https://images.unsplash.com/photo-1462275646964-a0e3386b89fa?auto=format&fit=crop&q=80&w=800', 'Source', 'http://127.0.0.1:8000/articles/test-article-4', 4000, 2, NOW(), 3, NOW(), NOW());
