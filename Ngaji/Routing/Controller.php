<?php namespace Ngaji\Routing;

use App\models\Accounts;
use app\models\Admins;
use app\models\Member;
use app\models\Ustadz;
use Ngaji\Http\Request;
use Ngaji\Http\Response;
use Ngaji\Http\Session;

/**
 * Controller(Base)
 *
 * This is a simple controller class
 *
 * @package app/Ngaji/Routing
 * @author  Ocki Bagus Pratama
 * @since   1.0.0
 */
class Controller {

    /**
     * Use this function for authenticated member and ustadz
     * if the authenticated is failure, the user will be redirect to
     * warning page that they can input username and pass again
     *
     * @param $username : username user
     * @param $password : password user
     * @return bool
     */
    public static function auth($username, $password) {
        $data = Accounts::findOne([
            'username' => $username,
            'password' => md5($password)
        ]);

        if ($data) { # validate was successed

            /*
             * Custom, originally not come from Ngaji Framework
             */
            switch ($data->type) {
                case 1:
                    $data = Admins::findOne($data->id);
                    break;
                case 2:
                    $data = Ustadz::findOne($data->id);
                    break;
                case 3:
                    $data = Member::findOne($data->id);
            }


            # Set a session ID
            $account = array(
                $data->id,
                $data->username,
                $data->name,
                $data->type
            );

            $session = new Session();
            $session->set('id_account', implode('|', $account));
            return TRUE;
        }

        # validate was failure
        return FALSE;

    }

    /**
     * Login required decorator
     * Inspired by Django 
     * @param  mixed $role 
     * @return Controller  self instance static
     */
    public static function login_required($role = null) {
        if (!Request::is_authenticated())
            Response::redirect('');

        /*
         * If role defined as int objects
         */
        if (is_int($role)) {
            $type = Request::get_user('type');
        } else { # if role defined as String objects
            $type = strtolower(Request::get_user('type-display'));
        }
        
        /*
         * Match the role with current active user
         */
        if ($role and !($role == $type))
            Response::redirect('');

        return new static;
    }
}