DROP TABLE IF EXISTS Scan; 
DROP TABLE IF EXISTS Login; 
DROP TABLE IF EXISTS Penukaran;
DROP TABLE IF EXISTS Peserta;
DROP TABLE IF EXISTS Peran; 
DROP TABLE IF EXISTS Item;

CREATE TABLE Peran ( 
    id VARCHAR(10) NOT NULL, 
    nama VARCHAR(20) NOT NULL, 
    skor_beri INT, 
    PRIMARY KEY(id), 
    UNIQUE(id)
); 



CREATE TABLE Item ( 
    id VARCHAR(10) NOT NULL, 
    nama VARCHAR(40) NOT NULL, 
    harga INT, 
    PRIMARY KEY(id), 
    UNIQUE(id)
); 



CREATE TABLE Peserta( 
    id VARCHAR(10) NOT NULL, 
    uname VARCHAR(25), 
    pass VARCHAR(60) NOT NULL, 
    skor INT DEFAULT 0, 
    fk_peran VARCHAR(10), 
--    nama_peran VARCHAR(20) NOT NULL, 
    PRIMARY KEY(id), 
    UNIQUE(id), 
    FOREIGN KEY (fk_peran) REFERENCES Peran(id) ON DELETE SET NULL ON UPDATE CASCADE
); 



CREATE TABLE Scan ( 
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fk_peserta_dari VARCHAR(10) NOT NULL, 
    fk_peserta_ke VARCHAR(10) NOT NULL, 
    FOREIGN KEY (fk_peserta_dari) REFERENCES Peserta(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (fk_peserta_ke) REFERENCES Peserta(id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE Login ( 
--    id_login VARCHAR(10) NOT NULL, 
    fk_user VARCHAR(10) NOT NULL, 
    token VARCHAR(60) NOT NULL, 
    login_pas TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    akt_trahir TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(token), 
    UNIQUE(token), 
--    UNIQUE(fk_user), 
    FOREIGN KEY (fk_user) REFERENCES Peserta(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- INSERT INTO Login (fk_user, token) VALUES ("ID1", "nj0Hg-aUMjQfA6p8cP7B*uWk_A$X-f2tAyvjdAmDHOaxwGQ"); -- , "Startup");
-- INSERT INTO Login (fk_user, token) VALUES ("ID4", "2EtPuROE2-7nzx60k,pZH6'QEA2t8Qcukzg_d!nTA"); -- , "Pengunjung");


CREATE TABLE Penukaran ( 
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fk_pengunjung VARCHAR(10) NOT NULL, 
    fk_item VARCHAR(10) NOT NULL, 
--    UNIQUE(fk_pengunjung),
--    UNIQUE(fk_item),
    FOREIGN KEY (fk_pengunjung) REFERENCES Peserta(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (fk_item) REFERENCES Item(id) ON DELETE CASCADE ON UPDATE CASCADE
);



INSERT INTO Peran VALUES ("PER01", "Game", 100);
INSERT INTO Peran VALUES ("PER02", "Startup", 1);
INSERT INTO Peran VALUES ("PER03", "Panitia", 0);
INSERT INTO Peran VALUES ("PER04", "Pengunjung", 0);

-- =========DUMMY======================

INSERT INTO Peran VALUES ("ID1", "Game", 100);
INSERT INTO Peran VALUES ("ID2", "Startup", 1);
INSERT INTO Peran VALUES ("ID3", "Panitia", 0);
INSERT INTO Peran VALUES ("ID4", "Pengunjung", 0);


INSERT INTO Item VALUES ("ID1", "FlashDisk", 100);
INSERT INTO Item VALUES ("ID2", "Beras", 10);
INSERT INTO Item VALUES ("ID3", "PC", 20);
INSERT INTO Item VALUES ("ID4", "Nasi", 200);

INSERT INTO Peserta VALUES ("ID1", "Abidin", "abcd", 0, "ID2"); -- , "Startup");
INSERT INTO Peserta VALUES ("ID2", "Abidin1", "abcd", 0, "ID4"); -- , "Pengunjung");
INSERT INTO Peserta VALUES ("ID3", "Abidin2", "abcd", 0, "ID3"); -- , "Panitia");
INSERT INTO Peserta VALUES ("ID4", "Abidin3", "abcd", 0, "ID1"); -- , "Game");

