USE mini_proyecto;

-- Contraseña por defecto para 'admin': 'admin123'
INSERT INTO usuarios (usuario, password) VALUES 
('admin', '$2y$10$4.tEamY271w8N4rGq970n.22qHw9X2fF7c5.q0s0Wv1QxW3qH1/6O')
ON DUPLICATE KEY UPDATE id=id;

-- Datos de prueba iniciales
INSERT INTO clientes (nombre, email, observaciones) VALUES
('Juan Pérez', 'juan@example.com', 'Cliente preferente'),
('Ana Gómez', 'ana@example.com', 'Sin observaciones'),
('Carlos Ruiz', 'carlos@example.com', 'Contactar por las mañanas');