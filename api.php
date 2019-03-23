<?php
require "config.php";

class apiCtrl extends base
{
    var $key;
    public function main()
    {
        $this->key = APPID;
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
                //订单详情
            case 'get_goods_order':
                $this->get_goods_order();
                break;
                //创建订单
            case 'get_goods_create_order':
                $this->get_goods_create_order();
                break;
                //支付
            case "get_goods_pay":
                $this->get_goods_pay();
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
//        $tokenId = string::strip_html_tags_new ( $tokenId = isset($_POST['tokenId']) ? $_POST['tokenId'] : '' );
//        $res = $this->check_user();
        $catelog = intval(string::strip_html_tags_new ( $catelog = isset($_GET['catelog']) ? (int)$_GET['catelog'] : 0 ));
        if($catelog == 0){
            $list = $obj->select("shop_goods_main");
            echo json_encode( $list );
        }else{
            $list = $obj->get_array("select * from shop_goods_main where catelog=$catelog");
            if(!$list){
                echo '[]';
            }else{
                echo json_encode( $list );
            }
            
        }

    }

    private function get_goods_info(){
        require_once 'classes/index.class.php';
        $obj = new indexClass();
//         $obj->debug=true;
        require_once 'classes/String.class.php';
        $id = intval(string::strip_html_tags_new ( $id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ));
//        $tokenId = string::strip_html_tags_new ( $tokenId = isset($_POST['tokenId']) ? $_POST['tokenId'] : '' );
//        $res = $this->check_user();
        if($id <= 0){
            echo '{"resutl":1,"msg":"输入错误"}';exit();
        }
        $info = $obj->select_one("shop_goods_main","id=$id");
//         print_r($info);
        $condition = array("where"=>"goods_id=$id","order"=>"desc_id asc");
        $condition_desc = array("where"=>"goods_id=$id");
        $condition_detail = array("where"=>"goods_id=$id");

        $list = $obj->select("shop_goods_desc",$condition);
        $desc = $obj->get_array("select * from shop_goods_desc where goods_id = $id");
        $detail = $obj->get_array("select * from shop_goods_detail where goods_id = $id");
//        $desc = $obj->select("shop_goods_desc",$condition_desc);
//        $detail = $obj->select("shop_goods_detail",$condition_detail);
        if($list){
            $info['info'] = $list;
            $info['desc'] = $desc;
            $info['detail'] = $detail;
        }else{
            $info['info']=array();
        }
        
        echo json_encode( $info );
    }

    private function get_goods_order(){
        $resp = "{'code': 200, 'msg': '操作成功~', 'data': {}}";
        require_once 'classes/index.class.php';
        $obj = new indexClass();
        require_once 'classes/String.class.php';
//        $res = $this->check_user();

        $user_id=1;
//        $goods_id = intval(string::strip_html_tags_new ( $id = isset($_GET['goods_id']) ? (int)$_GET['goods_id'] : 0 ));
        $detail_id = intval(string::strip_html_tags_new ( $id = isset($_GET['detail_id']) ? (int)$_GET['detail_id'] : 0 ));
        $nums = intval(string::strip_html_tags_new ( $num = isset($_GET['num']) ? (int)$_GET['num'] : 0 ));
        $address_id = intval(string::strip_html_tags_new ( $num = isset($_GET['address_id']) ? (int)$_GET['address_id'] : 0 ));
        $goods_detail = $obj->select_one("shop_goods_detail","detail_id=$detail_id");
        $goods_main = $obj->select_one("shop_goods_main","id=".$goods_detail['goods_id']."");


        $price =$goods_detail['price'] * $nums;
        if($address_id == 0){
            $user_address = $obj->select_one("shop_user_address","user_id=$user_id and if_default=0");
        }else{
            $user_address = $obj->select_one("shop_user_address","user_id=$user_id and address_id=$address_id");
        }

        if($id <= 0){
            echo '{"resutl":1,"msg":"输入错误"}';exit();
        }
        $goods_detail['total_price'] = $price;
        $goods_detail['main_title'] = $goods_main['title'];
        $goods_detail['main_image'] = $goods_main['image'];
        if($user_address){
            $goods_detail['address'] = $user_address;
        }else{
            $goods_detail['address'] = array();
        }
        if($goods_detail['discount'] <= 0){
            $goods_detail['code'] = -1;
            $goods_detail['msg'] = '库存不足';
        }else{
            $goods_detail['code'] = 200;
            $goods_detail['msg'] = '创建订单';
            echo json_encode( $goods_detail );
        }


    }


    private function get_goods_create_order(){
        require_once 'classes/index.class.php';
        $obj = new indexClass();
        require_once 'classes/String.class.php';
        $user_id = 1;
        $detail_id = intval(string::strip_html_tags_new ( $id = isset($_GET['detail_id']) ? (int)$_GET['detail_id'] : 0 ));
        $nums = intval(string::strip_html_tags_new ( $num = isset($_GET['num']) ? (int)$_GET['num'] : 0 ));
        $address_id = intval(string::strip_html_tags_new ( $num = isset($_GET['address_id']) ? (int)$_GET['address_id'] : 0 ));
        $goods_detail = $obj->select_one("shop_goods_detail","detail_id=$detail_id");
        if($goods_detail['discount'] <= 0){
            echo '{"resutl":1,"msg":"库存不足"}';exit();
        }
        $price =$goods_detail['price'] * $nums;
        $salt = rand(1,10000);
        $order_sn = date('YmdHis').$salt;
        $time = time();
        $res = $obj->insert_sql("insert into shop_user_order(user_id,detail_id,address_id,order_sn,create_time,money) values('$user_id','$detail_id','$address_id','$order_sn','$time','$price')");
        $list = array();
        if($res){
            $list['id'] = $res;
            $list['order_sn'] = $order_sn;
            $list['total_price'] = $price;
        }

        echo json_encode( $list );
    }

    private function get_goods_pay(){
        require_once "../payment/client/WxPay.Api.php";
        require_once "../payment/client/WxPay.NativePay.php";
        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();

        //$total_fee = "1";//测试值，实际使用注释掉
        $out_trade_no = WxPayConfig::MCHID.date("YmdHis").rand(10,99);
        $time_start = date("YmdHis");
        $goods_tag = "vip30";
        $trade_type = "NATIVE";
        $product_id = isset($p_code)?$p_code:$product;//测试值，根据实际情况改变
        $input->SetBody($body);
        $input->SetAttach($attach);
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($total_fee);
        $input->SetGoods_tag($goods_tag);
        $input->SetDetail($goods_detail);
        $input->SetTime_start($time_start);
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url("http://pay.doc88.com/payment/client/response.php");
        $input->SetTrade_type($trade_type);
        $input->SetProduct_id($product_id);
        $result = $notify->GetPayUrl($input);

    }


    private function get_address(){
        //$this->check_user();
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


    private function login()
    {
        // 获取数据并记录
        if (isset($_GET['code'])) {
            $code = $_GET['code']; // 登录临时凭证
        } else {
            echo '{"result":"2","message":"code null"}';
            exit();
        }
        // 登录凭证校验
        require_once 'classes/index.class.php';
        $obj = new indexClass();
        /**
         * 在不满足UnionID下发条件的情况下，返回参数
         * 参数 说明
         * openid 用户唯一标识
         * session_key 会话密钥
         * 在满足UnionID下发条件的情况下，返回参数
         * 参数 说明
         * openid 用户唯一标识
         * session_key 会话密钥
         * unionid 用户在开放平台的唯一标识符
         */
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . APPID . '&secret=' . SECRET . '&js_code=' . $code . '&grant_type=authorization_code';
        $result = file_get_contents($url);
        $result = json_decode($result);
    
        $userid = 0;
        if (isset($result->openid)) {
            $ip = $this->get_ip();
            //$sql = "select * from nxcx_user where openid='" . $result->openid . "'";
            //$res = mysqli_query($this->link, $sql);
            $res = $obj->select_one("shop_user_main", "openid='".$result->openid."'");
            //$num = mysqli_num_rows($res);
            if ($res) {
                $userid = $res['user_id'];
            } else {
                //$sql1 = "insert into nxcx_user(openid,session_key,ipstr,info,network,refer,time,cfg) value('" . $result->openid . "','" . $result->session_key . "','" . $ip . "','" . $systeminfo . "','" . $network . "','" . $refer . "','" . time() . "','" . $cfg . "');";
                //mysqli_query($this->link, $sql1);
                $obj->insert_sql("insert into shop_user_main(openid) values ('".$result->openid."')");
                $userid = mysqli_insert_id($obj->link);
            }
    
            // 返回tokenid
            require_once ('classes/des1.class.php');
    
            $encrypt = new des1($this->key);
            $tokenId = $encrypt->encrypt($result->openid . '@@' . time() . '@@' . $userid);
            $tokenId = str_replace('+', '-', $tokenId);
            $tokenId = str_replace('/', '_', $tokenId);
            $tokenId = str_replace('=', '*', $tokenId);
            header('Content-type: application/json');
    
            $expires = time() + 3600;
            echo '{"result":"0","tokenid":"' . $tokenId . '","userid":"' . $userid . '","expires":"' . $expires . '000"}';
        } else {
            echo '{"result":"1","message":"' . $result->errcode . '"}';
        }
    }
    //获取ip
    function get_ip(){
        $ip=false;
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip){
                array_unshift($ips, $ip); $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++){
                if(strpos($ips[$i],'know') > 0){// unknow
                    continue;
                }
                if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])){
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }
    //校验用户
    function check_user(){
        $tokenid = $_GET['tokenid'];
        if ($tokenid==""||$tokenid=="undefined") {
            echo '{"result":-1, "message":"tokenid无效"}';
            exit ();
        }
    
        require_once ('classes/des1.class.php');
        	
        $encrypt = new des1($this->key);
        $tokenid=str_replace('-','+',$tokenid);
        $tokenid=str_replace('_','/',$tokenid);
        $tokenid=str_replace('*','=',$tokenid);
    
        $tokenid = $encrypt->decrypt($tokenid);
    
    
        $tokenid_array = explode ( '@@', $tokenid );
        // 		echo time().'--';
        if(!is_array($tokenid_array)){
            echo '{"result":-1, "message":"tokenid不合法"}';
            exit ();
        }
        if(!isset($tokenid_array['2'])||$tokenid_array['2']<1){
            echo '{"result":-1, "message":"id不合法"}';
            exit ();
        }
        // 		echo $hours = (time() - $tokenid_array[1])/3600;
        // 		if ($hours > 48) {
        // 			echo '{"result":0, "message":"tokenid过期"}';
        // 			exit ();
        // 		}
        if (count ( $tokenid_array ) > 0) {
            if($tokenid_array[2]==1){
                $tokenid_array[2]=508;
            }
    
            return $tokenid_array;
        } else {
            echo '{"result":-1, "message":"tokenid不合法"}';
            exit ();
        }
    }




}
$api = new apiCtrl();
$api->main();
unset($api);