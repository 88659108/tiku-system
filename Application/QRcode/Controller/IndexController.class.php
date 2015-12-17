<?php
namespace QRcode\Controller;
use Think\Controller;


class IndexController extends Controller {
    public function index(){
        
		$userid		= get_sessions('userid');
		$upaperid	= I('upaperid', 0, 'int');
		$papertitle	= I('papertitle', '');
		$pageurl	= urldecode(I('pageurl', ''));
		if($userid == 0 || $upaperid == 0 || $papertitle == '' || $pageurl == ''){
			//var_dump($userid, $upaperid, $papertitle);
			//print '缺少参数..';
			//exit;	
		}
		
		$sessionid	= session_id();
		$session	= $_SESSION;
		$salt		= rand(1000,9999);
		$randcode	= md5($sessionid . $salt . $userid);
		
		//生成二维码
		import('Lib.Com.QRcode');
		$PNG_TEMP_DIR 	= TEMP_PATH . DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR	= RUNTIME_PATH . 'Temp/';
		
	
		//二维码数据
		$urldata		= 'http://www.zoobao.com/index.php/QRcode/Index/qrcodeurl?randcode=' . $randcode;
		$qrcodeurl 		= $PNG_TEMP_DIR. md5($userid . $upaperid) . '.png';
		\QRcode::png($urldata, $qrcodeurl, 'H', 8, 2);
		
		
		//彩色水印
		$logo 	= '.' . C('TMPL_PARSE_STRING.__IMG__') . 'app_logo.gif';
		$QR 	= $PNG_WEB_DIR . basename($qrcodeurl);//已经生成的原始二维码图
		if ($logo !== FALSE) { 
			$QR = imagecreatefromstring(file_get_contents($QR)); 
			$logo = imagecreatefromstring(file_get_contents($logo)); 
			$QR_width = imagesx($QR);//二维码图片宽度 
			$QR_height = imagesy($QR);//二维码图片高度 
			$logo_width = imagesx($logo);//logo图片宽度 
			$logo_height = imagesy($logo);//logo图片高度 
			$logo_qr_width = $QR_width / 5; 
			$scale = $logo_width/$logo_qr_width; 
			$logo_qr_height = $logo_height/$scale; 
			$from_width = ($QR_width - $logo_qr_width) / 2; 
			
			//重新组合图片并调整大小 
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,  
			$logo_qr_height, $logo_width, $logo_height); 
		} 
		
		//输出图片
		if(file_exists($qrcodeurl)) @unlink ($qrcodeurl); 
		$qrcodeurl 		= $PNG_WEB_DIR. md5($userid . $upaperid) . '1.png';
		imagepng($QR, $qrcodeurl);
		
		
		
		
		$qrdata				= array(
			'userid'		=> $userid,
			'username'		=> get_sessions('username'),
			'upaperid'		=> $upaperid,
			'papertitle'	=> $papertitle,
			'sessionid'		=> $sessionid,
			'sessiondata'	=> serialize($session),
			'qrcodeurl'		=> basename($qrcodeurl),
			'salt'			=> $salt,
			'addtime'		=> time(),
			'nums'			=> 1,
			'pageurl'		=> serialize($pageurl)
		);
		
		//写入数据库
		$qrcode				= D('QRcode/QRcode');
		$result				= $qrcode->data($qrdata)->add();
		$returndata			= array('status'=>0, 'info'=>'生成失败，请重新生成二维码！');
		if($result){
			
			//写入缓存
			$qrdata['dataid']	= $result;
			$mcwirte			= S($randcode, $qrdata, 3600);
			if($mcwirte){
				
				//返回客户端
				$imgurl					= '/'.$PNG_WEB_DIR.basename($qrcodeurl);
				$returndata['imgurl']	= $imgurl;
				$returndata['status']	= 1;
				$returndata['info']		= '扫描二维码，马上切换到手机版！';
			}
		}
		 
		$this->ajaxReturn($returndata);
    }
	
	
	
	public function qrcodeurl(){
		
		//临时获取码
		$randcode		= I('randcode', '');
		
		//读取缓存
		$qrdata			= S($randcode);
		$pageurl		= unserialize($qrdata['pageurl']);
		
		//删除二维码
		$PNG_TEMP_DIR 	= TEMP_PATH . DIRECTORY_SEPARATOR;
		$qrcodeurl 		= $PNG_TEMP_DIR . $qrdata['qrcodeurl'];
		if(file_exists($qrcodeurl)) @unlink ($qrcodeurl); 
		
		//恢复session
		session_destroy();
		session_start();
		$_SESSION		= unserialize($qrdata['sessiondata']);
		
		//完成登陆，跳转至地址
		header("Location: " . $pageurl); 
		
		exit;
	}
	
	
}