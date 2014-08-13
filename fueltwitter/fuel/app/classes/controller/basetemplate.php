    
<?php
    
    class Controller_BaseTemplate extends Controller_Template { 


        public function before()
    {
        parent::before();
        $method = Uri::segment(2);
        // ログインチェック
        $auth_methods = array(
            'logined',
            'logout',
        );
        if (in_array($method, $auth_methods) && !Auth::check()) {
            Response::redirect('login/login');
        }
        // ログイン済みチェック
        $nologin_methods = array(
            'login',
        );
        if (in_array($method, $nologin_methods) && Auth::check()) {
            Response::redirect('home');
        }
    }

}