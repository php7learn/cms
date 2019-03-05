<?php
// $db=new dbengine('127.0.0.1','root','','demo12',DEBUG);
/*
$data['uname']='tesssddst';
$data['nick_name']='年后';
$data['passwd']=md5('123');

$db->insert('user',$data);
$db->update('user',$data,'id=10');
$db->select('user','id=4');
$db->delete('user','id=10');
*/
class dbengine{
	public $link;
	public $debug;

	function __construct(){
		$this->debug=DEBUG;
		$this->link = new mysqli(DB_HOST,DB_USER,DB_PWD, DB_NAME);
		$this->link->set_charset("utf8");
		
		if($this->debug){
			echo "执行SQL: 连接MYSQL<br>\n";
			if(mysqli_connect_errno()){
				printf("连接失败: %s\n", mysqli_connect_error());
			}else{
				printf("mysql连接成功<br>\n");
				printf("mysql字符集设置：%s<br>\n", $this->link->character_set_name());
				printf("连接版本: %d<br>\n", $this->link->client_version);
				printf("主机信息: %s<br>\n", $this->link->server_info);
			}
		}
	}
	function select($table,$condition=array('where'=>'','order'=>'','offset'=>'','limit'=>''),$items='*'){
		$sql = array();
		$sql[] = "select $items from $table ";
		if(isset($condition['where'])&&$condition['where'] !== "") {
			$sql[] = "where ".$condition['where']; 
		}
		if(isset($condition['order'])&&$condition['order'] !== "") {
			$order = $condition['order'];
			$sql[] = " order by $order";
		}else{
			$sql[] = " order by id desc ";
		}
		if(isset($condition['offset'])&&$condition['offset'] !== "") {
			$offset = $condition['offset'];
		}else{
			$offset = 0;
		}
		if(isset($condition['limit'])&&$condition['limit'] !== "") {
			$limit = $condition['limit'];
			$sql[] = " limit $offset,$limit";
		}
		$sql = implode($sql);
// 		echo $sql;exit;
// 		$sql="select $items from $table where $where limit $offset,$limit";
		$res = $this->link->query($sql);
		if($res){
			while ($row = $res->fetch_assoc()) {
				$result[]=$row;
			}
			$num=$res->num_rows;
		}else{
			echo $this->link->error;
			return false;
		}

		if($this->debug){
			echo '<hr>执行SQL:'.$sql."<br>\n";
			if($res){
				printf("查询行数 (select): %d<br>\n", $num);
				if($num){
					echo "查询结果：";
					print_r($result);
				}
			}else{
				printf("查询失败: %s\n", $this->link->error);
			}
		}
		
		if($num){
			return $result;
		}else{
			return false;
		}
		
	}
	function select_one($table,$where,$items='*'){
		if($where == ""){
			return false;
		}
		$sql = "select $items from $table where $where";
		$res = $this->link->query($sql);
		$num=$res->num_rows;
		if($num){
			return $result = $res->fetch_assoc();
		}else{
			return false;
		}
	}

	function get_array($sql){
        $res = $this->link->query($sql);
        $num=$res->num_rows;
        if($num){
            return $result = $res->fetch_assoc();
        }else{
            return false;
        }
    }

	function select_sum($table,$where="1",$items='*'){
		echo $sql = "select sum($items) as sum from $table where $where";
		$res = $this->link->query($sql);
		$num=$res->num_rows;
		if($num){
			return $result = $res->fetch_assoc();
		}else{
			return false;
		}
	}
	function update($table,$data,$condition=""){
		if( !is_array($data) || count($data)<=0) {
			return false;
		}
		$value = "";
		while (list($k, $v) = each($data)) {
                if (empty($value)) {
                    $value = "$k='$v'";
                } else {
                    $value .= ",$k='$v'";
                }
        }
		$sql = "update $table set $value where 1=1 and $condition";
		$res = $this->link->query($sql);
		if($this->debug){
			echo '<hr>执行SQL:'.$sql."<br>\n";
			if($res){
				printf("更新影响行数 (update): %d<br>\n", $this->link->affected_rows);
			}else{
				printf("更新失败: %s\n", $this->link->error);
			}
		}
		return $res;
	}
	function insert($table,$data){
		if( !is_array($data) || count($data)<=0) {
			return false;
		}
		$field='';
		$value='';
		while (list($k, $v) = each($data)) {
                if (empty($field)) {
                    $field = "$k";
                    $value = "'$v'";
                } else {
                    $field .= ",$k";
                    $value .= ",'$v'";
                }
            }
		$sql = "insert into $table($field) values($value)";
		$res = $this->link->query($sql);
		if($this->debug){
			echo '<hr>执行SQL:'.$sql."<br>\n";
			if($res){
				printf("插入ID (INSERT): %d<br>\n", $this->link->insert_id);
			}else{
				printf("插入失败: %s\n", $this->link->error);
			}
		}
		if($res){
			return $this->link->insert_id;
		}else{
			return false;
		}
	}

	function insert_sql($sql){
        $res = $this->link->query($sql);
        if($this->debug){
            echo '<hr>执行SQL:'.$sql."<br>\n";
            if($res){
                printf("插入ID (INSERT): %d<br>\n", $this->link->insert_id);
            }else{
                printf("插入失败: %s\n", $this->link->error);
            }
        }
        if($res){
            return $this->link->insert_id;
        }else{
            return false;
        }
    }
	function delete($table,$where ){
		if( $where=='') {
			return false;
		}
		$sql = "delete from $table where $where";
		$res = $this->link->query($sql);
		if($this->debug){
			echo '<hr>执行SQL:'.$sql."<br>\n";
			if($res){
				printf("删除成功条数(DELETE): %d<br>\n", $this->link->affected_rows);
			}else{
				printf("删除失败: %s\n", $this->link->error);
			}
		}
		if($res){
			return $this->link->affected_rows;
		}else{
			return false;
		}
	}
	function selectcount($table,$where='1' ){

		$sql = "select count(*) as total from $table where $where";
// 		echo $sql;
		$res = $this->link->query($sql);
		$finfo = $res->fetch_object();
// 		print_r($finfo);
		if($this->debug){
			echo '<hr>执行SQL:'.$sql."<br>\n";
			if($res){
				printf("查到数据: %d条<br>\n", $finfo->total);
			}else{
				printf("查询失败: %s\n", $this->link->error);
			}
		}
		if($res){
			return $finfo->total;
		}else{
			return false;
		}
	}
	//记录日志
	//0 登录  1 退出登录   2发布文章 3 删除文章 4 修改文章 
	function add_log($message,$type=0){
		$data = array();
		$data['user_id'] = $_SESSION['id'];
		$data['descr'] = $message;
		$data['type'] = $type;
		$data['act_time'] = time();
		$data['ip'] = $this->getIP();
		
		$table = "log";
		$res = $this->insert($table,$data);
	}
	// 定义一个函数getIP()
	function getIP(){
		$ip = "";
		if (getenv("HTTP_CLIENT_IP")){
			$ip = getenv("HTTP_CLIENT_IP");
		}else if(getenv("HTTP_X_FORWARDED_FOR")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}else if(getenv("REMOTE_ADDR")){
			$ip = getenv("REMOTE_ADDR");
		}else $ip = "Unknow";
		return $ip;
	}
	function __destruct(){
		$res = $this->link->close();
		if($this->debug){
			echo "<hr>析构函数，释放mysql连接<br>\n";
			if($res){
				echo "释放连接成功<br>\n";
			}else{
				printf("释放连接失败: %s\n", $this->link->error);
			}
		}
	}
}