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
            case 'user':
                $this->user_list();
                break;
            case 'goods':
                $this->goods_list();
                break;
            case 'goods_page':
                $this->goods_list_page();
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
    function user_list()
    {
        require_once 'classes/admin.class.php';
         
        $question = new adminClass();
        $id = isset($_GET['id']) ? $_GET['id'] : 1 ;
        $res = $question->select_one("shop_goods_main","id='$id'");
        //         print_r($res);
        $this->tpl->assign("test", "test");
        $this->tpl->display("user.html");
    }
    function goods_list()
    {
        require_once 'classes/admin.class.php';
         
        $obj = new adminClass();
        $count = $obj->get_goods_count();
        $this->tpl->assign("list", $count);
        $this->tpl->display("goodslist.html");
    }
    function goods_list_page()
    {
        require_once 'classes/admin.class.php';
        
        $obj = new adminClass();
        $list = $obj->get_goods();
        $this->tpl->assign("list", $list);
        $this->tpl->display("goodslistpage.html");
    }
    function good_edit(){
    }
    function index()
    {
        echo "hello";
    }
}
$index = new adminCtrl();
$index->main();
unset($index);