-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE Kayttaja (
  kayttajaID     SERIAL PRIMARY KEY,
  kayttajaTunnus VARCHAR(20) NOT NULL,
  salasana       VARCHAR(20) NOT NULL
);
 
CREATE TABLE Askare (
  askareID    SERIAL PRIMARY KEY,
  kuvaus      VARCHAR(1000),
  tarkeysAste INT
);
 
CREATE TABLE AskareLista (
  kayttajaID INT,
  askareID   INT,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID),
  FOREIGN KEY (askareID) REFERENCES Askare (askareID)
);
 
CREATE TABLE Askel (
  askelID SERIAL PRIMARY KEY,
  kuvaus  VARCHAR(1000)
);
 
CREATE TABLE AskelLista (
  askareID INT,
  askelID  INT,
  jarjestys INT,
  FOREIGN KEY (askareID) REFERENCES Askare (askareID),
  FOREIGN KEY (askelID) REFERENCES Askel (askelID)
);
 
CREATE TABLE Luokka (
  luokkaID SERIAL PRIMARY KEY,
  nimi     VARCHAR(50)
);
 
CREATE TABLE LuokkaLista (
  luokkaID INT,
  askareID INT,
  FOREIGN KEY (luokkaID) REFERENCES Luokka (luokkaID),
  FOREIGN KEY (askareID) REFERENCES Askare (askareID)
);