<?php

class AskareetController extends BaseController {

    public static function index() {
        // Haetaan kaikki pelit tietokannasta
        $askareet = Askare::all();
        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
        View::make('askare/index.html', array('askareet' => $askareet));
    }

}
