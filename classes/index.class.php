<?php
class indexClass extends dbengine{
	
	public function get_user_photos($id){
	    $result = array();
	    $sql = "select * from pku_photo where owner=$id order by id asc;";
	    $res = $this->link->query($sql);
	    while ($row = $res->fetch_assoc()) {
	        $result[]=$row;
	    }
	    return $result;
	}
}