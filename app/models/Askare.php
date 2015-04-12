<?php

class Askare extends BaseModel {

    public $askareid, $kuvaus, $tarkeysaste, $nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_tarkeysaste', 'validate_kuvaus');
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
        $query = DB::connection()->prepare('INSERT INTO Askare (nimi, tarkeysaste, kuvaus) VALUES (:nimi, :tarkeysaste, :kuvaus) RETURNING askareid');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('nimi' => $this->nimi, 'tarkeysaste' => $this->tarkeysaste, 'kuvaus' => $this->kuvaus));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->askareid = $row['askareid'];
    }

    public function validate_nimi() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->nimi) < 3) {
            $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
        }
        if (strlen($this->nimi) > 50) {
            $errors[] = 'Nimen pituuden tulee olla alle 50 merkkiä!';
        }

        return $errors;
    }
    
    public function validate_tarkeysaste() {
        $errors = array();
        if ($this->tarkeysaste == '' || $this->tarkeysaste == null) {
            $errors[] = 'Aseta askareelle tärkeysaste!';
        }
        if (!is_numeric($this->tarkeysaste)) {
            $errors[] = 'Tärkeysasteen täytyy olla numeerinen!';
        }
        if (is_numeric($this->tarkeysaste) && ($this->tarkeysaste < 1 || $this->tarkeysaste > 5)) {
            $errors[] = 'Tärkeysasteen täytyy olla numero väliltä 1-5!';
        }

        return $errors;
    }
    
    public function validate_kuvaus() {
        $errors = array();
        if ($this->kuvaus == '' || $this->kuvaus == null) {
            $errors[] = 'Kuvaus ei saa olla tyhjä!';
        }
        if (strlen($this->kuvaus) > 1000) {
            $errors[] = 'Kuvaus ei saa olla yli tuhat merkkiä pitkä!';
        }

        return $errors;
    }

}
