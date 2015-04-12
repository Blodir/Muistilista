<?php

class AskareetController extends BaseController {

    public static function index() {
        // Haetaan kaikki pelit tietokannasta
        $askareet = Askare::all();
        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $askareet datalla
        View::make('askare/index.html', array('askareet' => $askareet));
    }

    public static function uusi() {
        View::make('askare/uusi.html');
    }

    public static function show($id) {
        $askareet = Askare::find($id);
        View::make('askare/show.html', array('askareet' => $askareet));
    }

    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        $askare = new Askare(array(
            'nimi' => $params['nimi'],
            'tarkeysaste' => (int) $params['tarkeysaste'],
            'kuvaus' => $params['kuvaus']
                //TODO: algoritmi joka erittelee luokat tekstistä
        ));
        //Kint::dump($askare);
        $errors = $askare->errors();

        if (count($errors) == 0) {
            $askare->save();
            Redirect::to('/askare/' . $askare->askareid, array('message' => 'Askareen lisäys onnistui!'));
        } else {
            View::make('askare/uusi.html', array('errors' => $errors, 'attributes' => $askare));
        }
    }

}
