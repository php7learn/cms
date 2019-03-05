<?php
require "config.php";

class apiCtrl extends base
{

    public function main()
    {
        $this->setsubtemplates('index');
        $act = isset($_GET['act']) ? $_GET['act'] : '';
        switch ($act) {
            case 'login':
                $this->login();
                break;
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
        $user_id = string::strip_html_tags_new ( $weight = isset($_POST['user_id']) ? (int)$_POST['user_id'] : '' );
        $post_code = string::strip_html_tags_new ( $weight = isset($_POST['post_code']) ? $_POST['post_code'] : '' );
        if($type == 0){
//            $res = $obj->insert_sql("insert into ");
        }
        var_dump($type);
    }

    private function login(){
        //获取数据并记录
        if(isset($_GET['code'])){
            $code = $_GET['code'];//登录临时凭证
        }else{
            echo '{"result":"2","message":"code null"}';
            exit();
        }
        require_once 'classes/index.class.php';
        $obj = new indexClass();
        //保存附加信息
        /* $systeminfo = isset($_GET['systeminfo'])?addslashes($_GET['systeminfo']):"";
        $network = isset($_GET['network'])?addslashes($_GET['network']):"";
        $refer = isset($_SERVER["HTTP_REFERER"])?addslashes($_SERVER["HTTP_REFERER"]):'';
          */
        //登录凭证校验
        /**
         在不满足UnionID下发条件的情况下，返回参数
         参数	说明
         openid	用户唯一标识
         session_key	会话密钥
         在满足UnionID下发条件的情况下，返回参数
         参数	说明
         openid	用户唯一标识
         session_key	会话密钥
         unionid	用户在开放平台的唯一标识符
         **/
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.APPID.'&secret='.APPSECRET.'&js_code='.$code.'&grant_type=authorization_code';
        $result = file_get_contents($url);
        $result = json_decode($result);
        //unionid
        if(isset($result->openid)){
            if(isset($result->unionid)){
                $unionid = $result->unionid;
                $member_id = $obj->getonerow($unionid, "edc_member_bind_unionid", "bind_id");
                $member_id = array("member_id"=>573);
                if($member_id){
                    $member_id = $member_id['member_id'];
                    $obj->execute("insert into edc_miniprogram_login_log(member_id,unionid,openid,time) values (".$member_id.",'".$unionid."','".$result->openid."',".time().")");
                    $key = Common::get_authcode_key ();
                    $tokenId = Common::authcode ($unionid.'@@'.$member_id. '@@' .$result->openid . '@@' . time (), $operation = 'ENCODE', $key, $expiry = 0);
                    $tokenId=str_replace('+','-',$tokenId);
                    $tokenId=str_replace('/','_',$tokenId);
                    $tokenId=str_replace('=','*',$tokenId);
                    echo json_encode(array("result"=>"0","token"=>$tokenId));
                }else{
                    echo '{"result":"4","message":"No userid"}';
                }
            }else{
                echo '{"result":"3","message":"No unionid"}';
            }
        }else{
            echo '{"result":"1","message":"'.$result->errcode.'"}';
        }
    }





}
$api = new apiCtrl();
$api->main();
unset($api);