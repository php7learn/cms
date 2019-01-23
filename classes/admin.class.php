<?php
class adminClass extends dbengine{
	
	public function get_goods(){
	    $result = array();
	    $sql = "select * from shop_goods_main where state=1 order by id asc;";
	    $res = $this->link->query($sql);
	    while ($row = $res->fetch_assoc()) {
	        $result[]=$row;
	    }
	    return $result;
	}
}