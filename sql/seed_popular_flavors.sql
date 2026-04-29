INSERT INTO flavors (name, price, image_path) VALUES
('Classic Vanilla Bean', 400, 'asset/p2.png'),
('Fresh Strawberry', 450, 'asset/p3.png'),
('Mint Chocolate Chip', 500, 'asset/p4.png'),
('Tutti Frutti Mix', 480, 'asset/p5.png'),
('Royal Hot Fudge Sundae', 850, 'asset/p6.png')
ON DUPLICATE KEY UPDATE
price = VALUES(price),
image_path = VALUES(image_path);
