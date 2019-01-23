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
        require_once 'classes/admin.class.php';
         
        $question = new adminClass();
        $id = isset($_GET['id']) ? $_GET['id'] : 1 ;
        $res = $question->select_one("shop_goods_main","id='$id'");
//         print_r($res);
        $this->tpl->assign("test", "test");
        $this->tpl->display("main.html");
    }

    function index()
    {
        echo "hello";
    }
}
$index = new adminCtrl();
$index->main();
unset($index);