<?php

class AskareetController extends BaseController {

    public static function index() {
        // Haetaan kaikki pelit tietokannasta
        $askareet = Askare::all();
        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
        View::make('askare/index.html', array('askareet' => $askareet));
    }
    
    public static function uusi() {
        View::make('askare/uusi.html');
    }

    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        $askare = new Askare(array(
            'nimi' => $params['nimi'],
            'tarkeysaste' => $params['tarkeysaste'],
            'kuvaus' => $params['kuvaus']
            //TODO: algoritmi joka erittelee luokat tekstistä
        ));
        Kint::dump($params);
        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $askare->save();

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        //Redirect::to('/askare/' . $askare->askareid, array('message' => 'Peli on lisätty kirjastoosi!'));
    }

}
