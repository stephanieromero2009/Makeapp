

CREATE DATABASE IF NOT EXISTS bd_maquillaje CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bd_maquillaje;

-- Tabla principal de productos de maquillaje
CREATE TABLE IF NOT EXISTS tbmaquillaje (
  id INT AUTO_INCREMENT PRIMARY KEY,           -- identificador único
  codigo VARCHAR(20) NOT NULL UNIQUE,          -- código del producto (ej. LAB-001)
  nombre VARCHAR(100) NOT NULL,                -- nombre comercial
  marca VARCHAR(60) NOT NULL,                  -- marca (cara o de farmacia)
  categoria VARCHAR(40) NOT NULL,              -- labial, base, rubor, etc.
  tipo_piel ENUM('seca','grasa','mixta','sensible') NOT NULL,
  tono_piel ENUM('clara','media','morena','oscura') NOT NULL,
  subtono ENUM('frio','calido','neutro') NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  link_imagen VARCHAR(255),                    -- URL de la imagen del producto
  ingredientes TEXT                            -- lista de ingredientes separados por coma
);

-- Datos de ejemplo (marcas caras y de farmacia para comparar)
INSERT INTO tbmaquillaje (codigo,nombre,marca,categoria,tipo_piel,tono_piel,subtono,precio,link_imagen,ingredientes) VALUES
('LAB-001','Rouge Velvet #C2185B','Dior','labial','seca','clara','frio',890.00,'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=400','Ricinus Communis Oil, Cera Alba, Isopropyl Myristate, Tocopherol'),
('LAB-002','Matte Ink #D81B60','Maybelline','labial','mixta','media','neutro',189.00,'https://images.unsplash.com/photo-1631214540553-ff044a3ff1d4?w=400','Dimethicone, Isododecane, Trimethylsiloxysilicate, Parfum'),
('LAB-003','Coral Glow #E5675B','e.l.f.','labial','sensible','morena','calido',120.00,'https://images.unsplash.com/photo-1599733589046-10c005739ef0?w=400','Shea Butter, Jojoba Oil, Vitamin E'),
('LAB-004','Berry Night #7B1F4B','Fenty Beauty','labial','grasa','oscura','frio',650.00,'https://images.unsplash.com/photo-1625093742435-6fa192b6fb10?w=400','Polybutene, Lanolin, Coconut Oil, Silica'),
('BAS-001','Base Fit Me 220','Maybelline','base','grasa','media','calido',215.00,'https://images.unsplash.com/photo-1631730486572-226d1f595a1e?w=400','Aqua, Cyclopentasiloxane, Isopropyl Palmitate, Talc'),
('BAS-002','Hydra Skin Tint','Clinique','base','sensible','clara','neutro',980.00,'https://images.unsplash.com/photo-1599305090598-fe179d501227?w=400','Aqua, Glycerin, Hyaluronic Acid, Niacinamide');
