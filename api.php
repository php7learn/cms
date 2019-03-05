<?php
require "config.php";

class apiCtrl extends base
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
            case 'get_goods_list':
                $this->get_goods_list();
                break;
            //获取指定商品信息
            case 'get_goods_info':
                $this->get_goods_info();
                break;
            //地址管理
            case 'get_address':
                $this->get_address();
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
    private function get_goods_list(){
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
        echo json_encode( $info );
    }


    private function get_address(){
        require_once 'classes/index.class.php';
        $obj = new indexClass();
        require_once 'classes/String.class.php';

        $type =intval(string::strip_html_tags_new ( $weight = isset($_GET['type']) ? (int)$_GET['type'] : 0 ));
        $addr = string::strip_html_tags_new ( $weight = isset($_POST['address']) ? $_POST['address'] : '' );
        $phone = string::strip_html_tags_new ( $weight = isset($_POST['phone']) ? $_POST['phone'] : '' );
        $name = string::strip_html_tags_new ( $weight = isset($_POST['name']) ? $_POST['name'] : '' );
        $user_id = intval(string::strip_html_tags_new ( $weight = isset($_POST['user_id']) ? (int)$_POST['user_id'] : '' ));
        $post_code = string::strip_html_tags_new ( $weight = isset($_POST['post_code']) ? $_POST['post_code'] : '' );
        $address_id = intval(string::strip_html_tags_new ( $weight = isset($_GET['address_id']) ? (int)$_GET['address_id'] : '' ));
        $time = time();
        if(empty( $phone ) && $type != 2){
            echo '{"resutl":1,"msg":"手机号码为空"}';exit();
        }
        if($type == 0){
            $res = $obj->insert_sql("insert into shop_user_address(name,address,user_id,post_code,phone,create_time) values('$name','$addr','$user_id','$post_code','$phone','$time')");
            if($res){
                echo '{"resutl":"'.$res.'","msg":"新增地址成功"}';exit();
            }else{
                echo '{"resutl":1,"msg":"新增地址失败"}';exit();
            }

        }
        if($type == 1){
            $res = $obj->update_sql("update shop_user_address set name='$name',address='$addr',phone='$phone',post_code='$post_code',update_time='$time' where address_id='$address_id' and user_id='$user_id'");
            if($res){
                echo '{"resutl":0,"msg":"更新地址成功"}';exit();
            }else{
                echo '{"resutl":1,"msg":"更新地址失败"}';exit();
            }
        }

        if($type == 2){
            $res = $obj->delete("shop_user_address","address_id=$address_id");
            if($res){
                echo '{"resutl":0,"msg":"删除地址成功"}';exit();
            }else{
                echo '{"resutl":1,"msg":"删除地址失败"}';exit();
            }
        }

//        var_dump($type);
    }







}
$api = new apiCtrl();
$api->main();
unset($api);