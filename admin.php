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
            case 'good_edit':
                $this->good_edit();
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
         
        $obj = new adminClass();
        $count = $obj->get_users_count();
        $this->tpl->assign("count", $count);
        $this->tpl->display("userlist.html");
    }
    
    function user_list_page()
    {
        require_once 'classes/admin.class.php';
        
        $obj = new adminClass();
        if(isset($_GET['page']) && $_GET['page']>0){
            $page = (int)$_GET['page'];
        }else{
            $page = 1;
        }
        if(isset($_GET['limit']) && $_GET['limit']>0){
            $limit = (int)$_GET['limit'];
        }else{
            $limit = 10;
        }
        $list = $obj->get_users($page,$limit);
        $num = count($list);
        $this->tpl->assign("list", $list);
        $this->tpl->assign("num", $num);
        $this->tpl->display("userlistpage.html");
    }
    function goods_list()
    {
        require_once 'classes/admin.class.php';
         
        $obj = new adminClass();
        $count = $obj->get_goods_count();
        $this->tpl->assign("count", $count);
        $this->tpl->display("goodslist.html");
    }
    function goods_list_page()
    {
        require_once 'classes/admin.class.php';
        
        $obj = new adminClass();
        if(isset($_GET['page']) && $_GET['page']>0){
            $page = (int)$_GET['page'];
        }else{
            $page = 1;
        }
        if(isset($_GET['limit']) && $_GET['limit']>0){
            $limit = (int)$_GET['limit'];
        }else{
            $limit = 10;
        }
        $list = $obj->get_goods($page,$limit);
        $num = count($list);
        $this->tpl->assign("list", $list);
        $this->tpl->assign("num", $num);
        $this->tpl->display("goodslistpage.html");
    }
    function order_list()
    {
        require_once 'classes/admin.class.php';
        
        $obj = new adminClass();
        $count = $obj->get_orders_count();
        $this->tpl->assign("count", $count);
        $this->tpl->display("orderlist.html");
    }
    function order_list_page()
    {
        require_once 'classes/admin.class.php';
        
        $obj = new adminClass();
        if(isset($_GET['page']) && $_GET['page']>0){
            $page = (int)$_GET['page'];
        }else{
            $page = 1;
        }
        if(isset($_GET['limit']) && $_GET['limit']>0){
            $limit = (int)$_GET['limit'];
        }else{
            $limit = 10;
        }
        $list = $obj->get_orders($page,$limit);
        $num = count($list);
        $this->tpl->assign("list", $list);
        $this->tpl->assign("num", $num);
        $this->tpl->display("orderlistpage.html");
    }

    function good_edit(){
        $this->tpl->display("goodedit.html");
    }
    function index()
    {
        echo "hello";
    }
}
$index = new adminCtrl();
$index->main();
unset($index);