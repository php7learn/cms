<?php
class adminClass extends dbengine{
	
	public function get_goods($page = 1,$limit){
	    //$sql = "select * from shop_goods_main where state=1 order by id asc;";
	    //$res = $this->link->query($sql);
	    $offset = ($page-1)*$limit;
	    $condition=array('where'=>'state=1','order'=>'id asc','offset'=>$offset,'limit'=>$limit);
	    $res = $this->select('shop_goods_main',$condition);
	    return $res;
	}
	
	public function get_goods_count(){
	    $count = $this->selectcount('shop_goods_main','state=1');
	    return $count;
	}
	
	public function get_users($page = 1,$limit){
	    //$sql = "select * from shop_goods_main where state=1 order by id asc;";
	    //$res = $this->link->query($sql);
	    $offset = ($page-1)*$limit;
	    $condition=array('where'=>'1','order'=>'user_id asc','offset'=>$offset,'limit'=>$limit);
	    $res = $this->select('shop_user_main',$condition);
	    return $res;
	}
	
	public function get_users_count(){
	    $count = $this->selectcount('shop_user_main');
	    return $count;
	}
	public function get_orders($page = 1,$limit){
	    //$sql = "select * from shop_goods_main where state=1 order by id asc;";
	    //$res = $this->link->query($sql);
	    $offset = ($page-1)*$limit;
	    $condition=array('where'=>'1','order'=>'order_id asc','offset'=>$offset,'limit'=>$limit);
	    $res = $this->select('shop_user_order',$condition);
	    return $res;
	}
	
	public function get_orders_count(){
	    $count = $this->selectcount('shop_user_order');
	    return $count;
	}
}