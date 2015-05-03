<?php

class Askare extends BaseModel {

    public $askareid, $kuvaus, $tarkeysaste, $nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_tarkeysaste', 'validate_kuvaus');
    }

    public static function all($kayttajaid) {
        $query = DB::connection()->prepare('SELECT A.askareid, kuvaus, tarkeysaste, nimi FROM AskareLista AL, Askare A WHERE kayttajaid = :kayttajaid AND A.askareid = AL.askareid');
        $query->execute(array('kayttajaid' => $kayttajaid));
        $rows = $query->fetchAll();
        $askareet = array();

        foreach ($rows as $row) {
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
        $query = DB::connection()->prepare('INSERT INTO Askare (nimi, tarkeysaste, kuvaus) VALUES (:nimi, :tarkeysaste, :kuvaus) RETURNING askareid');
        $query->execute(array('nimi' => $this->nimi, 'tarkeysaste' => $this->tarkeysaste, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        $this->askareid = $row['askareid'];
    }
    
    public function update($id) {
        $this->askareid = $id;
        $query = DB::connection()->prepare('UPDATE Askare SET nimi = :nimi, tarkeysAste = :tarkeysaste, kuvaus = :kuvaus WHERE askareID = :askareid RETURNING askareid');
        $query->execute(array('nimi' => $this->nimi, 'tarkeysaste' => $this->tarkeysaste, 'kuvaus' => $this->kuvaus, 'askareid' => $this->askareid));
    }

    public function delete($id) {
        $query = DB::connection()->prepare('DELETE FROM Askare WHERE askareid = :askareid');
        $query->execute(array('askareid' => $id));
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
