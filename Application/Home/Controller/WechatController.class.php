<?php
namespace Home\Controller;
use Think\Controller;
class WechatController extends Controller {
    private static $appid = '';
    private static $secret = '';
    public function _initialize(){
        // $this->appid='wxb61637dbbd5c5e8e';
        // $this->secret = '8763b9da9d69c9e865cfb21708e6d25f';
        $this->appid='wx79471f40b33ae84f';
        $this->secret = '0891d9d89fb012683565031b5a85b731';
    }
    public function index(){
        if(isset($_GET["code"]))
        {
            // m.cpb.iprotime.com;
            $code=$_GET["code"];
            $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code';
            $data=$this->https_request($url);
            $data=json_decode($data);
            $access_token_url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->secret;
            $access_token=json_decode($this->https_request($access_token_url));
            $info_url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token->access_token.'&openid='.$data->openid.'&lang=zh_CN';
            $info=json_decode($this->https_request($info_url));
            $_SESSION['memberinfo']=$info;
            $this->redirect('Home/Query/index',array('openid' =>$data->openid));
        }else{
            $redirectUrl='http://m.xiyuasset.com/wechat?from=zjyx';
            /*
            scope=snsapi_base 静默授权
            scope=snsapi_userinfo 手动同意
            */
            $oaurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" .$this->appid. "&redirect_uri=".urlencode($redirectUrl)."&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";
            header("location:$oaurl");
        }
    }
    // http请求方法
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}