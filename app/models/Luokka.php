<?php

class Luokka extends BaseModel {

    public $nimi, $luokkaid;

    public static function save($nimi) {
        $query = DB::connection()->prepare('INSERT INTO Luokka (nimi) VALUES (:nimi) RETURNING luokkaid');
        $query->execute(array('nimi' => $nimi));
        $row = $query->fetch();
        
        return $row['luokkaid'];
        
    }
    
    public static function findByNimi($luokkanimi) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE nimi = :luokkanimi');
        $query->execute(array('luokkanimi' => $luokkanimi));
        $row = $query->fetch();
        if ($row) {
            $luokka = new Luokka(array(
                'nimi' => $row['nimi'],
                'luokkaid' => $row['luokkaid']
            ));
            return $luokka;
        }
        return null;
    }

    public static function findAll($askareid) {
        $query = DB::connection()->prepare('SELECT L.luokkaID, nimi FROM LuokkaLista LL, Luokka L WHERE askareID = :askareid AND L.luokkaID = LL.luokkaID');
        $query->execute(array('askareid' => $askareid));
        $rows = $query->fetchAll();
        $luokat = array();
        foreach ($rows as $row) {
            $luokat[] = new Luokka(array(
                'nimi' => $row['nimi']
            ));
        }

        return $luokat;
    }

}
