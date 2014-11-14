<?php

namespace App\Setup;

class Setup extends \App\Controller {
    public function __construct( $params, $config, $filter, $user ) {
        parent::__construct( $params, $config, $filter, $user );

        \Cohuatl\View::getInstance()->register(__DIR__);
    }

    public function index() {
        $config = $this->getConfig();

        // If we have no valid config, we are setting up the site for the first time.
        if($config['default'] || $this->checkAuth()) {
            echo $this->wrapLayout($this->getView('views/setup.php', ['config' => $config]));
        } else {
            echo $this->getUnauthorized();
        }
    }

    public function save() {
        $config = $this->getConfig();

        if(!$config['default'] && !$this->checkAuth()) {
            echo $this->getUnauthorized();

            return;
        }

        echo $this->wrapLayout($this->getView('views/setup.php', ['config' => $config]));
    }

    private function checkAuth() {
        return $this->user['cohuatl.logged_in'] && $this->user['cohuatl.is_admin'];
    }

    private function getUnauthorized() {
        return $this->wrapLayout($this->getView('views/unauthorized.php'));
    }

    private function getConfig() {
        return new \App\Model\Config(new \Cohuatl\Store('BlogConfig'));
    }
}
