<?php

class Askare extends BaseModel {

    public $askareID, $kuvaus, $tarkeysAste, $nimi;

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
                'askareID' => $row['askareID'],
                'kuvaus' => $row['kuvaus'],
                'tarkeys' => $row['tarkeysAste'],
                'nimi' => $row['nimi']
            ));
        }

        return $askareet;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE askareID = :askareID LIMIT 1');
        $query->execute(array('askareID' => $id));
        $row = $query->fetch();

        if ($row) {
            $askare[] = new Askare(array(
                'askareID' => $row['askareID'],
                'kuvaus' => $row['kuvaus'],
                'tarkeysAste' => $row['tarkeysAste'],
                'nimi' => $row['nimi']
            ));

            return $askare;
        }

        return null;
    }

}
