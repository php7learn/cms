<?php

class base{
	public $tpl;
	
	public function __construct(){
		require ROOT."/lib/Smarty.class.php";
		$this->tpl=new Smarty;
		$this->tpl->left_delimiter=LEFT_DELIMITER;
		$this->tpl->right_delimiter=RIGHT_DELIMITER;
		$this->tpl->caching=CACHING;
		$this->tpl->cache_dir=CACHE_DIR;
		$this->tpl->cache_lifetime=CACHE_TIME;
		
		//过滤参数
		$_GET = $this->_addslashes($_GET);
		$_POST = $this->_addslashes($_POST);
		$_COOKIE = $this->_addslashes($_COOKIE);
	}
	//验证登录情况 type为验证级别，9为最高级别
	public function logined_check($type=0){
		$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
		if ($id != ''&&$_SESSION['level']>=$type) {
			return $_SESSION['level'];
		} else {
			header("Location:/");
			return false;
		}
	}
	//设置模板位置
	public function setsubtemplates($dir=''){
		$tempdir=ROOT."/templates/".$dir;
		$tempdir_c=ROOT."/templates_c/".$dir;
		$this->tpl->assign("site_url",SITE_STATIC);
		$this->tpl->assign("site_static",SITE_STATIC."/assets/");
		$this->tpl->setTemplateDir($tempdir)->setCompileDir($tempdir_c);
	}
	// 递归转义数组
	public function _addslashes($arr) {
		foreach($arr as $k=>$v) {
			if(is_string($v)) {
				$arr[$k] = addslashes($v);
			} else if(is_array($v)) {  // 再加判断,如果是数组,调用自身,再转
				$arr[$k] = _addslashes($v);
			}
		}
	
		return $arr;
	}
}