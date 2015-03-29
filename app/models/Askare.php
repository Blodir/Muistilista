<?php

class Askare extends BaseModel {

    public $askareid, $kuvaus, $tarkeysaste, $nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Askare');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $askareet = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $askareet[] = new Askare(array(
                'askareid' => $row['askareid'],
                'kuvaus' => $row['kuvaus'],
                'tarkeysaste' => $row['tarkeysaste'],
                'nimi' => $row['nimi']
            ));
        }

        return $askareet;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE askareid = :askareid LIMIT 1');
        $query->execute(array('askareid' => $id));
        $row = $query->fetch();

        if ($row) {
            $askare[] = new Askare(array(
                'askareid' => $row['askareid'],
                'kuvaus' => $row['kuvaus'],
                'tarkeysaste' => $row['tarkeysaste'],
                'nimi' => $row['nimi']
            ));

            return $askare;
        }

        return null;
    }

    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Game (nimi, tarkeysaste, kuvaus) VALUES (:nimi, :tarkeysaste, :kuvaus) RETURNING askareid');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('name' => $this->name, 'published' => $this->published, 'publisher' => $this->publisher, 'description' => $this->description));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->askareid = $row['askareid'];
    }

}
