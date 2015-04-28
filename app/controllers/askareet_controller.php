<?php

class AskareetController extends BaseController {

    public static function index() {
        $askareet = Askare::all();
        View::make('askare/index.html', array('askareet' => $askareet));
    }

    public static function muokkaa($id) {
        $askare = Askare::find($id);
        Kint::dump($askare);
        View::make('askare/edit.html', array('attributes' => $askare));
    }

    public static function uusi() {
        View::make('askare/uusi.html');
    }

    public static function show($id) {
        $askareet = Askare::find($id);
        $luokat = Luokka::findAll($id);
        View::make('askare/show.html', array('askareet' => $askareet, 'luokat' => $luokat));
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
            AskareetController::jaaLuokkiin($askare->askareid, $params['luokat']);
            Redirect::to('/askare/' . $askare->askareid, array('message' => 'Askareen lisäys onnistui!'));
        } else {
            View::make('askare/uusi.html', array('errors' => $errors, 'attributes' => $askare));
        }
    }
    
    public static function jaaLuokkiin($askareid, $luokkajono) {
        $luokkanimet = explode(' ', $luokkajono);
        foreach ($luokkanimet as $luokkanimi) {
            if (Luokka::findByNimi($luokkanimi) != NULL) {
                LuokkaLista::save($askareid, Luokka::findByNimi($luokkanimi)->luokkaid);
            } else {
                $luokkaid = Luokka::save($luokkanimi);
                LuokkaLista::save($askareid, $luokkaid);
            }
        }
    }

    public static function update($id) {
        $params = $_POST;
        $askare = new Askare(array(
            'nimi' => $params['nimi'],
            'tarkeysaste' => (int) $params['tarkeysaste'],
            'kuvaus' => $params['kuvaus']
        ));
        $errors = $askare->errors();

        if (count($errors) == 0) {
            $askare->update($id);
            Redirect::to('/askare/' . $askare->askareid, array('message' => 'Askareen muokkaus onnistui!'));
        } else {
            View::make('askare/edit.html', array('errors' => $errors, 'attributes' => $askare));
        }
    }

    public static function destroy($id) {
        $askare = new Askare(array('id' => $id));
        $askare->delete($id);
        Redirect::to('/askareet', array('message' => 'Askareen poistaminen onnistui!'));
    }
}
