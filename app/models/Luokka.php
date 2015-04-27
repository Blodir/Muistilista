<?php

class Luokka extends BaseModel {
    public $nimi;
    
    public static function findAll($askareid) {
        $query = DB::connection()->prepare('SELECT * FROM LuokkaLista WHERE askareID = :askareid');
        $query->execute(array($askareid => 'askareid'));
        $rows = $query->fetchAll();
        $luokat = array();
        foreach ($rows as $row) {
            $luokat[] = new Luokka(array(
                'nimi' => $row['nimi'],
            ));
        }

        return $luokat;
    }
    
}