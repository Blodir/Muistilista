<?php

class AskareetController extends BaseController {

    public static function index() {
        $askareet = Askare::all();
        View::make('askare/index.html', array('askareet' => $askareet));
    }

    public static function muokkaa($id) {
        $askare = Askare::find($id);
        View::make('askare/edit.html', array('attributes' => $askare));
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

    public static function update() {
        $params = $_POST;
        $askare = new Askare(array(
            'nimi' => $params['nimi'],
            'tarkeysaste' => (int) $params['tarkeysaste'],
            'kuvaus' => $params['kuvaus']
                //TODO: algoritmi joka erittelee luokat tekstistä
        ));
        $errors = $askare->errors();

        if (count($errors) == 0) {
            $askare->update();
            Redirect::to('/askare/' . $askare->askareid, array('message' => 'Askareen muokkaus onnistui!'));
        } else {
            View::make('askare/edit.html', array('errors' => $errors, 'attributes' => $askare));
        }
    }

    public static function destroy($id) {
        $askare = new Askare(array('id' => $id));
        $askare->delete();
        Redirect::to('/askareet', array('message' => 'Askareen poistaminen onnistui!'));
    }
}
