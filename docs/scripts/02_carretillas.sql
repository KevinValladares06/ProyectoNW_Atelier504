CREATE TABLE `products` (
    `productId` int(11) NOT NULL AUTO_INCREMENT,
    `productName` varchar(255) NOT NULL,
    `productDescription` text NOT NULL,
    `productPrice` decimal(10, 2) NOT NULL,
    `productImgUrl` varchar(255) NOT NULL,
    `productStock` int(11) NOT NULL DEFAULT 0,
    `productStatus` char(3) NOT NULL,
    PRIMARY KEY (`productId`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4;

ALTER TABLE products
ADD COLUMN productStock INT(11) NOT NULL DEFAULT 0 AFTER productImgUrl;

CREATE TABLE `carretilla` (
    `usercod` BIGINT(10) NOT NULL,
    `productId` int(11) NOT NULL,
    `crrctd` INT(5) NOT NULL,
    `crrprc` DECIMAL(12, 2) NOT NULL,
    `crrfching` DATETIME NOT NULL,
    PRIMARY KEY (`usercod`, `productId`),
    INDEX `productId_idx` (`productId` ASC),
    CONSTRAINT `carretilla_user_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `carretilla_prd_key` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `carretillaanon` (
    `anoncod` varchar(128) NOT NULL,
    `productId` bigint(18) NOT NULL,
    `crrctd` int(5) NOT NULL,
    `crrprc` decimal(12, 2) NOT NULL,
    `crrfching` datetime NOT NULL,
    PRIMARY KEY (`anoncod`, `productId`),
    KEY `productId_idx` (`productId`),
    CONSTRAINT `carretillaanon_prd_key` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE pedidos (
    pedidoId INT AUTO_INCREMENT NOT NULL,
    usercod BIGINT(10) NOT NULL,
    fchpedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (pedidoId),
    CONSTRAINT pedidos_usr_key FOREIGN KEY (usercod) REFERENCES usuario (usercod) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4;

CREATE TABLE detalle_pedidos (
    detalleId INT AUTO_INCREMENT NOT NULL,
    pedidoId INT NOT NULL,
    productoId INT(11) NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (detalleId),
    INDEX idx_pedidoId (pedidoId),
    INDEX idx_productoId (productoId),
    CONSTRAINT fk_pedidoId FOREIGN KEY (pedidoId) REFERENCES pedidos (pedidoId) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_productoId FOREIGN KEY (productoId) REFERENCES products (productId) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;