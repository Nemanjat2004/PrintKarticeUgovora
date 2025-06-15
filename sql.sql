-- Brisanje ako već postoje
DROP TABLE IF EXISTS uplata;
DROP TABLE IF EXISTS izvod;
DROP TABLE IF EXISTS rate;
DROP TABLE IF EXISTS ugovori;
DROP TABLE IF EXISTS stanovi;
DROP TABLE IF EXISTS stranke;

-- Tabela stranke
CREATE TABLE stranke (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(50),
    prezime VARCHAR(50)
);

INSERT INTO stranke (ime, prezime) VALUES
('Petar', 'Petrović'),
('Jovan', 'Jovanović');

-- Tabela stanovi
CREATE TABLE stanovi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naziv VARCHAR(100),
    adresa VARCHAR(100)
);

INSERT INTO stanovi (naziv, adresa) VALUES
('Stan A', 'Bulevar Oslobođenja 1'),
('Stan B', 'Cara Dušana 25');

-- Tabela ugovori
CREATE TABLE ugovori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    broj_ugovora VARCHAR(50),
    ukupan_iznos DECIMAL(10,2),
    datum_vazenja DATE,
    broj_rata INT,
    devizni BOOLEAN,
    id_stranke INT,
    id_stana INT,
    FOREIGN KEY (id_stranke) REFERENCES stranke(id),
    FOREIGN KEY (id_stana) REFERENCES stanovi(id)
);

INSERT INTO ugovori (broj_ugovora, ukupan_iznos, datum_vazenja, broj_rata, devizni, id_stranke, id_stana) VALUES
('UG-001', 60000.00, '2024-01-01', 6, 0, 1, 1),
('UG-002', 90000.00, '2024-03-01', 3, 0, 2, 2);

-- Tabela rate
CREATE TABLE rate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_ugovora INT,
    redni_broj INT,
    rev_vrednost DECIMAL(10,2),
    datum DATE,
    FOREIGN KEY (id_ugovora) REFERENCES ugovori(id)
);

INSERT INTO rate (id_ugovora, redni_broj, rev_vrednost, datum) VALUES
(1, 1, 10000.00, '2024-02-01'),
(1, 2, 10000.00, '2024-03-01'),
(1, 3, 10000.00, '2024-04-01'),
(1, 4, 10000.00, '2024-05-01'),
(1, 5, 10000.00, '2024-06-01'),
(1, 6, 10000.00, '2024-07-01');

-- Tabela izvod
CREATE TABLE izvod (
    id INT AUTO_INCREMENT PRIMARY KEY,
    datum DATE,
    potrazuje DECIMAL(10,2)
);

INSERT INTO izvod (datum, potrazuje) VALUES
('2024-03-15', 10000.00),
('2024-04-10', 30000.00),
('2024-05-10', 20000.00),
('2024-06-10', 10000.00);

-- Tabela uplata
CREATE TABLE uplata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_izvoda INT,
    id_ugovora INT,
    FOREIGN KEY (id_izvoda) REFERENCES izvod(id),
    FOREIGN KEY (id_ugovora) REFERENCES ugovori(id)
);

-- 1 uplata za prvi ugovor
INSERT INTO uplata (id_izvoda, id_ugovora) VALUES
(1, 1);

-- 3 uplate za drugi ugovor
INSERT INTO uplata (id_izvoda, id_ugovora) VALUES
(2, 2),
(3, 2),
(4, 2);
