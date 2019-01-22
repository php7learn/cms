<?php
require "config.php";

class adminCtrl extends base
{

    public function main()
    {
        $this->setsubtemplates('admin');
        $act = isset($_GET['act']) ? $_GET['act'] : '';
        
        switch ($act) {
            case 'test':
                $this->test();
                break;
            default:
                $this->index();
        }
    }

    function test()
    {
        $this->tpl->assign("test", "test");
        $this->tpl->display("test.html");
    }

    function index()
    {
        echo "hello";
    }
}
$index = new adminCtrl();
$index->main();
unset($index);