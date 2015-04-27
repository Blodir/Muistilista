<?php

class User extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $salasana;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaTunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1');
        $query->execute(array('kayttajatunnus' => $username, 'salasana' => $password));
        $row = $query->fetch();
        if ($row) {
            return new User(array(
                'kayttajaid' => $row['kayttajaid'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana']
            ));
        } else {
            return null;
        }
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid = :kayttajaid LIMIT 1');
        $query->execute(array('kayttajaid' => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja[] = new User(array(
                'kayttajaid' => $row['kayttajaid'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana']
            ));

            return $kayttaja;
        }

        return null;    
    }

}
