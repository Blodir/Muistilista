<?php

class LuokatController extends BaseController {

    public static function show($id) {
        $luokka = Luokka::findOne($id);
        $askareet = LuokkaLista::findAll($id);
        View::make('luokka/luokka.html', array('luokka' => $luokka, 'askareet' => $askareet));
    }

    public static function destroy($id) {
        $luokka = new Luokka(array());
        $luokka->delete($id);
        Redirect::to('/askareet', array('message' => 'Luokan poistaminen onnistui!'));
    }
    
    public static function muokkaa($id) {
        $luokka = Luokka::findOne($id);
        View::make('luokka/edit.html', array('luokka' => $luokka, 'errors' => null));
    }
    
    public static function update($id) {
        $params = $_POST;
        $luokka = new Luokka(array(
            'luokkaid' => $id,
            'nimi' => $params['nimi']
        ));
        $errors = $luokka->errors();

        if (count($errors) == 0) {
            $luokka->update();
            Redirect::to('/luokka/' . $id, array('message' => 'Luokan muokkaus onnistui!'));
        } else {
            View::make('luokka/edit.html', array('errors' => $errors, 'luokka' => $luokka));
        }
    }

}