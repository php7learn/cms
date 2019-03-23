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
}