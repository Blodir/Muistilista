INSERT INTO Askare (kuvaus, tarkeysAste, nimi) VALUES ('kuvailua', '5', 'testinimi');
INSERT INTO Kayttaja (kayttajaTunnus, salasana) VALUES ('testi', 'testi');
INSERT INTO Luokka (nimi) VALUES ('asd');
INSERT INTO LuokkaLista (luokkaID, askareID) VALUES ((SELECT luokkaID FROM Luokka WHERE nimi = 'asd'), (SELECT askareID FROM Askare WHERE nimi = 'testinimi'));