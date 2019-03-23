<?php
class adminClass extends dbengine{
	
	public function get_goods(){
	    $sql = "select * from shop_goods_main where state=1 order by id asc;";
	    //$res = $this->link->query($sql);
	    $condition=array('where'=>'state=1','order'=>'id asc','offset'=>'','limit'=>'10');
	    $res = $this->select('shop_goods_main',$condition);
	    return $res;
	}
}