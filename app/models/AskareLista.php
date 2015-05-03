<?php

class AskareLista extends BaseModel {

    public $askareid, $kayttajaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function delete($askareid) {
        $query = DB::connection()->prepare('DELETE FROM AskareLista WHERE askareid = :askareid');
        $query->execute(array('askareid' => $askareid));
    }

    public static function save($askareid, $kayttajaid) {
        $query = DB::connection()->prepare('INSERT INTO AskareLista VALUES (:kayttajaid, :askareid)');
        $query->execute(array('askareid' => $askareid, 'kayttajaid' => $kayttajaid));
    }

    public static function findAll($kayttajaid) {
        $query = DB::connection()->prepare('SELECT A.askareID, kuvaus, tarkeysAste, nimi FROM AskareLista LL, Askare A WHERE kayttajaID = :kayttajaid AND LL.askareID=A.askareID');
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

    public static function findOne($askareid, $kayttajaid) {
        $query = DB::connection()->prepare('SELECT * FROM AskareLista WHERE askareid = :askareid AND kayttajaid = :kayttajaid');
        $query->execute(array('askareid' => $askareid, 'kayttajaid' => $kayttajaid));
        $row = $query->fetch();
        if ($row) {
            $askarelista = new AskareLista(array(
                'kayttajaid' => $row['kayttajaid'],
                'askareid' => $row['askareid']
            ));

            return $askarelista;
        }

        return null;
    }

}
