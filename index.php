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
            //获取banner
            case 'get_banner':
                $this->get_banner();
                break;
            //获取分类
            case 'get_catelog':
                $this->get_catelog();
                break;
            //获取获取商品列表
            case 'get_catelog_list':
                $this->get_catelog_list();
                break;
            //获取指定商品信息
            case 'get_goods_info':
                $this->get_goods_info();
                break;
            default:
                $this->index();
        }
    }

    function index()
    {
        echo "hello";
    }

    //banner接口
    private function get_banner(){
        require_once 'classes/index.class.php';

        $obj = new indexClass();
        $res = $obj->select_one('shop_goods_main',1);
//        print_r($res);
        $list_banner = array('1.jpg','2.jpg','3.jpg');
        echo  json_encode($list_banner);
    }


    //分类接口 2级
    private function get_catelog(){
        $cat = array('生鲜'=>array('土豆','蔬菜'),'家电'=>array('洗衣机','电冰箱'),'厨具'=>array('刀','砧板'));
        echo json_encode($cat);
//        print_r($cat);
    }

    //获取列表
    private function get_catelog_list(){
        require_once 'classes/index.class.php';
        $obj = new indexClass();

        require_once 'classes/String.class.php';
        $catelog = intval(string::strip_html_tags_new ( $weight = isset($_GET['catelog']) ? (int)$_GET['catelog'] : 0 ));
        if($catelog == 0){
            $list = $obj->select("shop_goods_main");
            echo json_encode( $list );
        }else{
            $list = $obj->select("shop_goods_main","catelog=>$catelog");
            echo json_encode( $list );
        }

    }

    private function get_goods_info(){
        require_once 'classes/index.class.php';
        $obj = new indexClass();

        require_once 'classes/String.class.php';
        $id = intval(string::strip_html_tags_new ( $weight = isset($_GET['id']) ? (int)$_GET['id'] : 0 ));
        if($id <= 0){
            echo '{"resutl":1,"msg":"输入错误"}';exit();
        }
        $info = $obj->get_array("select * from shop_goods_main as t1 ,shop_goods_desc as t2 where t1.id=t2.goods_id and t1.id=$id");
        print_r($info);
    }








}
$index = new indexCtrl();
$index->main();
unset($index);