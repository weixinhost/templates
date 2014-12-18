<?php
/***
 * 该示例使用原生PHP开发了接收不同消息类型的处理模板。
 * Class WechatApplication
 */
class WechatApplication
{

    private $wechat = null;

    public function __construct(){
        $this->wechat = new WeixinhostWechat();
    }

    /****
     *
     * @param array $account 公众号在侯斯特的信息
     * @param array $message 微信消息XML解析后的数组
     * @param array $params 其他参数
     * @return mixed 返回给微信粉丝一条文字消息
     */
    public function text_handle($account,$message,$params = array()){
        $this->wechat->init($account,$message,$params);
        $send = "
openid:{$this->wechat->getRevFrom()}\n
公众号：{$account['name']}\n
";
        return $this->wechat->text($send)->reply();
    }

    /***
     * @param array $account 公众号在侯斯特的信息
     * @param array $message 微信消息XML解析后的数组
     * @param array $params  其他参数
     * @return mixed  返回微信粉丝一条图文消息
     */
    public function image_handle($account,$message,$params = array()){
        $this->wechat->init($account,$message,$params);
        $picUrl = $this->wechat->getRevPic(); //获取到微信粉丝发送的图片地址。该地址不会永久有效。
        $news = array(
            array(
                'Title'=>'图片消息',
                'Description'=>'侯斯特开放平台模板项目',
                'PicUrl'=>$picUrl,
                'Url'=>'http://www.weixinhost.com'
            )
        );
        return $this->wechat->news($news)->reply();
    }

    /***
     * @param array $account 公众号在侯斯特的信息
     * @param array $message 微信消息XML解析后的数组
     * @param array $params  其他参数
     * @return mixed  返回微信粉丝一条图文消息
     */
    public function location_handle($account,$message,$params = array()){
        $this->wechat->init($account,$message,$params);
        $location = $this->wechat->getRevGeo();
        $x = $location['x'];
        $y = $location['y'];
        $baiduStaticMap="http://api.map.baidu.com/staticimage?center={$x},{$y}&width=300&height=200&zoom=11";
        $news = array(
            array(
                'Title'=>'地理位置消息',
                'Description'=>'百度静态图API使用',
                'PicUrl'=>$baiduStaticMap,
                'Url'=>'http://www.weixinhost.com'
            )
        );
        return $this->wechat->news($news)->reply();
    }
}