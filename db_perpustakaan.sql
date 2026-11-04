CREATE DATABASE IF NOT EXISTS db_perpustakaan;
USE db_perpustakaan;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE buku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  penulis VARCHAR(100) NOT NULL,
  tahun_terbit INT NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  status VARCHAR(20) NOT NULL,
  sampul VARCHAR(255) DEFAULT NULL
);

INSERT INTO users (username, password) VALUES ('admin', MD5('admin123'));

INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, status, sampul) VALUES
('Pemrograman Web dengan PHP', 'Teknologi', 'Rudy Eko Prasetya', 2020, 5, 'Tersedia', ''),
('Laskar Pelangi', 'Novel', 'Andrea Hirata', 2005, 0, 'Dipinjam', '');