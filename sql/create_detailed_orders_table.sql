CREATE TABLE IF NOT EXISTS detailed_orders (
    detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    flavor_id INT NULL,
    flavor_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255) NULL,
    line_total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

