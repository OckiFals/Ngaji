<?php namespace app\controllers;

use app\models\Accounts;
use app\models\City;
use app\models\RegisterForm;
use Ngaji\Database\QueryBuilder;
use Ngaji\Http\Request;
use Ngaji\Http\Response;
use Ngaji\Http\Session;
use Ngaji\Routing\Controller;
use Ngaji\view\View;

class AccountsController extends Controller {
    /**
     * @login_required
     */
    public function index() {
        self::login_required();
        $accounts = Accounts::all();
        $title = 'Accounts all';

        View::render('account-all', [
            'accounts' => $accounts,
            'title' => $title
        ]);
    }

    /**
     * @login_required
     */
    public function add() {
        self::login_required();

        if ("POST" === Request::method()) {
            $form = new RegisterForm;
            $form->load(Request::POST());

            if ($form->validate()) {
                $account = new Accounts;
                /**
                 * only in sqlite you must gets the last of primary key id
                 */
                $last_id = (new QueryBuilder)->select('max(id)')
                    ->from('accounts')
                    ->asArray()
                    ->getOne();
                $account->id = $last_id+1;

                $account->name = $form->clean_data('name');
                $account->username = $form->clean_data('username');
                $account->password = $form->clean_data('password');
                $account->photo = '2.png';
                $account->city = $form->city;

                $account->save();

                Session::push('flash-message', 'Account baru berhasil ditambahkan!');
                Response::redirect('accounts');

            } else {
                print_r($form->getErrors());
                Session::push('flash-message', 'Terjadi error!');
                Response::redirect('accounts/add');
            }
        } else {
            $title = 'Accounts add';
            $cities = City::all();
            View::render('account-add', [
                'title' => $title,
                'cities' => $cities
            ]);
        }
    }

    /**
     * @login_required
     * @param $id
     * @return string
     */
    public function delete($id) {
        self::login_required();
        Accounts::delete($id);
        # push flash-message
        Session::push('flash-message', 'Account berhasil dihapus!');
        # redirect to main page
        Response::redirect('accounts');
    }
}