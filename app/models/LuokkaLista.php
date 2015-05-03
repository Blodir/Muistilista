<?php

class LuokkaLista extends BaseModel {

    public $askareid, $luokkaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function delete($askareid) {
        $query = DB::connection()->prepare('DELETE FROM LuokkaLista WHERE askareid = :askareid');
        $query->execute(array('askareid' => $askareid));
    }

    public static function save($askareid, $luokkaid) {
        $query = DB::connection()->prepare('INSERT INTO LuokkaLista VALUES (:luokkaid, :askareid)');
        $query->execute(array('askareid' => $askareid, 'luokkaid' => $luokkaid));
    }

    public static function findAll($luokkaid) {
        $query = DB::connection()->prepare('SELECT A.askareID, kuvaus, tarkeysAste, nimi FROM LuokkaLista LL, Askare A, AskareLista AL WHERE luokkaID = :luokkaid AND LL.askareID=A.askareID AND LL.askareID=AL.askareID AND AL.kayttajaID = :kayttajaid');
        $query->execute(array('luokkaid' => $luokkaid, 'kayttajaid' => BaseController::get_user_logged_in()->kayttajaid)); 
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

    public static function findOne($askareid, $luokkaid) {
        $query = DB::connection()->prepare('SELECT * FROM LuokkaLista WHERE askareid = :askareid AND luokkaid = :luokkaid');
        $query->execute(array('askareid' => $askareid, 'luokkaid' => $luokkaid));
        $row = $query->fetch();
        if ($row) {
            $luokkalista = new LuokkaLista(array(
                'luokkaid' => $row['luokkaid'],
                'askareid' => $row['askareid']
            ));

            return $luokkalista;
        }

        return null;
    }

}
