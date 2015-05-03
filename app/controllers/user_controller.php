<?php

class UserController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }
    
    public static function register() {
        View::make('user/register.html');
    }
    
    public static function store() {
        $params = $_POST;
        $attributes = array(
            'kayttajatunnus' => $params['kayttajatunnus'],
            'salasana' => $params['salasana']
        );
        $user = new User($attributes);
        $errors = $user->errors();
        if (count($errors) == 0) {
            $user->save();
            Redirect::to('/login', array('message' => 'Rekisteröityminen onnistui'));
        } else {
            View::make('user/register.html', array('errors' => $errors, 'attribuutit' => $attributes
            ));
        }
    }
    
    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->kayttajaid;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->kayttajatunnus . '!'));
        }
    }

}
