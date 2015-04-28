<?php

class LuokkaLista {
    public static function save($askareid, $luokkaid) {
        $query = DB::connection()->prepare('INSERT INTO LuokkaLista VALUES (:luokkaid, :askareid)');
        $query->execute(array('askareid' => $askareid, 'luokkaid' => $luokkaid));
    }
}