<?php
require "config.php";

class indexCtrl extends base
{

    public function main()
    {
        $this->setsubtemplates('index');
        $act = isset($_GET['act']) ? $_GET['act'] : '';
        switch ($act) {
            case 'setadmin':
                $this->setadmin();
                break;
            default:
                $this->index();
        }
    }

    function index()
    {
        echo "hello";
    }
}
$index = new indexCtrl();
$index->main();
unset($index);