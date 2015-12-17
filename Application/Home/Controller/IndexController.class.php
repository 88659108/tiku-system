<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //header("Location: http://www.zoobao.com/ask/?/account/login/");
        exit;

        /*E('本站暂时还在建设中....');

        $arr = array(
    "哥应邀参加前任婚礼，和一帮陌生人坐一桌， 旁边一哥们问我是新娘什么人？ 我回答，我只是来看一下以前战斗过的地方！",
    "哥应邀参加前任婚礼，和一帮陌生人坐一桌，旁边一哥们问我：“是新娘什么人？” 我回答，我只是来看一下以前战斗过的地方！
没想到一桌子的人举起酒杯：“大家都是战友，干杯，多喝点，一会讨论战斗经验！”",
    "哥应邀参加前任婚礼，和一帮陌生人坐一桌，旁边一哥们问我是新娘什么人？我回答，我只是来看一下以前战斗过的地方！没想到一桌子的人举起酒杯：大家都是战友，干杯，多喝点，一会讨论战斗经验！");

similar_text($arr[0], $arr[1], $p);
similar_text($arr[1], $arr[2], $e);
similar_text($arr[0], $arr[2], $r);

echo "$p    $e  $r";
exit;



       $Class	= D('question_tag');
       $list	= $Class->select();
       //var_dump($list);


       $array['name']    =    'thinkphp';
        $array['email']   =    'liu21st@gmail.com';
        $array['phone']   =    '12335678';
        $this->assign($array);
        exit;*/
        $this->display();
    }


}