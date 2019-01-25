INSERT INTO categoria (nombre) VALUES ('Fritos');
INSERT INTO categoria (nombre) VALUES ('Entrantes');
INSERT INTO categoria (nombre) VALUES ('Pescados');
INSERT INTO categoria (nombre) VALUES ('Variedades');

INSERT INTO producto (nombre, descripcion, precio, rutaimg, pedidomin, categoria_idcategoria) VALUES ('Corquetas de hongos', 'Ración 12 unidades', 5.00, '#', 2, 1);
INSERT INTO producto (nombre, descripcion, precio, rutaimg, pedidomin, categoria_idcategoria) VALUES ('Escalibada de verduras con ventresca de atún', 'Por raciones', 6.40,'#', 2, 2);
INSERT INTO producto (nombre, descripcion, precio, rutaimg, pedidomin, categoria_idcategoria) VALUES ('Canelones rellenos de espinacas y hongos', 'Por raciones', 3.75, '#', 2, 2);
INSERT INTO producto (nombre, descripcion, precio, rutaimg, pedidomin, categoria_idcategoria) VALUES ('Piquillos rellenos de merluza y gambas', 'Por raciones', 4.80, '#', 2, 3);
INSERT INTO producto (nombre, descripcion, precio, rutaimg, pedidomin, categoria_idcategoria) VALUES ('Bacalao a la Bizkaina', 'Por raciones', 8.00, '#', 2, 3);
INSERT INTO producto (nombre, descripcion, precio, rutaimg, pedidomin, categoria_idcategoria) VALUES ('Chipirones en su tinta', 'Por raciones', 6.00, '#', 2, 3);
INSERT INTO producto (nombre, descripcion, precio, rutaimg, pedidomin, categoria_idcategoria) VALUES ('Kokotxas de bacalao con gulas', 'Por raciones', 10.50, '#', 2, 3);
INSERT INTO producto (nombre, descripcion, precio, rutaimg, pedidomin, categoria_idcategoria) VALUES ('Plum cake con perlitas de chocolate', '8 raciones, precio por kilo', 11.00, '#', 1, 1);

INSERT INTO admin (nombre,pass) VALUES ('root','root');

-- Pedido 1
INSERT INTO cliente (idcliente, nombre, email, telefono) VALUES (NULL, 'Aitor', 'aitor@email.com', '666112233');
INSERT INTO pedido (idpedido, fecha, estado, precioTotal, cliente_idcliente) VALUES (NULL, '2019-01-24', '0', '10', '1');
INSERT INTO pedido_has_producto (pedido_idpedido, producto_idproducto, cantidad) VALUES ('1', '1', '2');

-- Pedido 2
INSERT INTO cliente (idcliente, nombre, email, telefono) VALUES (NULL, 'Jon', 'jon@email.com', '666445566');
INSERT INTO pedido (idpedido, fecha, estado, precioTotal, cliente_idcliente) VALUES (NULL, '2019-01-25', '1', '20', '2');
INSERT INTO pedido_has_producto (pedido_idpedido, producto_idproducto, cantidad) VALUES ('2', '1', '1');
INSERT INTO pedido_has_producto (pedido_idpedido, producto_idproducto, cantidad) VALUES ('2', '6', '1');

-- Pedido 3
INSERT INTO cliente (idcliente, nombre, email, telefono) VALUES (NULL, 'Unai', 'unai@email.com', '666778899');
INSERT INTO pedido (idpedido, fecha, estado, precioTotal, cliente_idcliente) VALUES (NULL, '2019-01-26', '1', '30', '3');
INSERT INTO pedido_has_producto (pedido_idpedido, producto_idproducto, cantidad) VALUES ('3', '1', '6');
INSERT INTO pedido_has_producto (pedido_idpedido, producto_idproducto, cantidad) VALUES ('3', '5', '1');