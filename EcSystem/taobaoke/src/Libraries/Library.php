<?php

namespace ES\Taobaoke\Libraries;

use ES\Taobaoke\SDK\top\request\TbkItemGetRequest;
use ES\Taobaoke\SDK\top\request\TbkItemRecommendGetRequest;
use ES\Taobaoke\SDK\top\request\TbkItemInfoGetRequest;
use ES\Taobaoke\SDK\top\request\TbkShopGetRequest;
use ES\Taobaoke\SDK\top\request\TbkShopRecommendGetRequest;
use ES\Taobaoke\SDK\top\request\TbkUatmEventGetRequest;
use ES\Taobaoke\SDK\top\request\TbkUatmEventItemGetRequest;
use ES\Taobaoke\SDK\top\request\TbkUatmFavoritesItemGetRequest;
use ES\Taobaoke\SDK\top\request\TbkUatmFavoritesGetRequest;
use ES\Taobaoke\SDK\top\request\TbkJuTqgGetRequest;
use ES\Taobaoke\SDK\top\request\TbkSpreadGetRequest;
use ES\Taobaoke\SDK\top\domain\TbkSpreadRequest;
use ES\Taobaoke\SDK\top\request\JuItemsSearchRequest;
use ES\Taobaoke\SDK\top\domain\TopItemQuery;
use ES\Taobaoke\SDK\top\request\TbkDgItemCouponGetRequest;
use ES\Taobaoke\SDK\top\request\TbkCouponGetRequest;
use ES\Taobaoke\SDK\top\request\TbkTpwdCreateRequest;
use ES\Taobaoke\SDK\top\request\TopAuthTokenCreateRequest;
use ES\Taobaoke\SDK\top\request\TbkDgNewuserOrderGetRequest;
use ES\Taobaoke\SDK\top\request\TbkScNewuserOrderGetRequest;
use ES\Taobaoke\SDK\top\request\TbkScMaterialOptionalRequest;
use ES\Taobaoke\SDK\top\request\TbkDgMaterialOptionalRequest;
use ES\Taobaoke\SDK\top\request\TbkDgNewuserOrderSumRequest;
use ES\Taobaoke\SDK\top\request\TbkScNewuserOrderSumRequest;
use ES\Taobaoke\SDK\top\request\TbkScPublisherInfoSaveRequest;
use ES\Taobaoke\SDK\top\request\TbkScPublisherInfoGetRequest;
use ES\Taobaoke\SDK\top\request\TbkScInvitecodeGetRequest;
use ES\Taobaoke\SDK\top\request\TbkOrderDetailsGetRequest;
use ES\Taobaoke\SDK\top\request\TbkOrderGetRequest;
use ES\Taobaoke\SDK\top\request\WirelessShareTpwdCreateRequest;
use ES\Taobaoke\SDK\top\domain\GenPwdIsvParamDto;
use ES\Taobaoke\SDK\top\request\WirelessShareTpwdQueryRequest;
use ES\Taobaoke\SDK\top\request\TbkContentGetRequest;
use ES\Taobaoke\SDK\top\request\TbkDgOptimusMaterialRequest;
use ES\Taobaoke\SDK\top\request\TbkScOptimusMaterialRequest;
use ES\Taobaoke\SDK\top\request\TbkCouponConvertRequest;
use ES\Taobaoke\SDK\top\request\TbkItemConvertRequest;
use ES\Taobaoke\SDK\top\request\TbkShopConvertRequest;
use ES\Taobaoke\SDK\top\request\TbkTpwdConvertRequest;
use ES\Taobaoke\SDK\top\TopClient;
use stdClass;
use Exception;

class Library extends Base
{
    // 淘宝客基础API
    /**
     * 淘宝客商品查询
     */
    public function taobaoTbkItemGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['q', 'cat', 'itemloc', 'sort', 'is_tmall', 'is_overseas', 'start_price', 'end_price', 'start_tk_rate', 'end_tk_rate', 'platform', 'page_no', 'page_size'];
        $req = new TbkItemGetRequest;
        $req->setFields('num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客商品关联推荐查询
     */
    public function taobaoTbkItemRecommendGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['num_iid', 'count', 'platform'];
        $req = new TbkItemRecommendGetRequest;
        $req->setFields('num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,nick,seller_id,volume');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客商品详情（简版）
     */
    public function taobaoTbkItemInfoGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['platform', 'num_iids'];
        $req = new TbkItemInfoGetRequest;
        // $req->setFields('num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,nick,seller_id,volume,cat_leaf_name,cat_name');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客店铺查询
     */
    public function taobaoTbkShopGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['q', 'sort', 'is_tmall', 'start_credit', 'end_credit', 'start_commission_rate', 'end_commission_rate', 'start_total_action', 'end_total_action', 'start_auction_count', 'end_auction_count', 'platform', 'page_no', 'page_size'];
        $req = new TbkShopGetRequest;
        $req->setFields('user_id,shop_title,shop_type,seller_nick,pict_url,shop_url');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客店铺关联推荐查询
     */
    public function taobaoTbkShopRecommendGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['user_id', 'count', 'platform'];
        $req = new TbkShopRecommendGetRequest;
        $req->setFields('user_id,shop_title,shop_type,seller_nick,pict_url,shop_url');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 枚举正在进行中的定向招商的活动列表
     */
    public function taobaoTbkUatmEventGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['page_no', 'page_size'];
        $req = new TbkUatmEventGetRequest;
        $req->setFields('event_id,event_title,start_time,end_time');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 获取淘宝联盟定向招商的宝贝信息
     */
    public function taobaoTbkUatmEventItemGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['platform', 'page_size', 'adzone_id', 'unid', 'event_id', 'page_no'];
        $req = new TbkUatmEventItemGetRequest;
        $req->setFields('num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,click_url,nick,seller_id,volume, shop_title, zk_final_price_wap,event_start_time,event_end_time,tk_rate,type,status');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 获取淘宝联盟选品库的宝贝信息
     */
    public function taobaotbkUatmFavoritesItemGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['platform', 'page_size', 'adzone_id', 'unid', 'favorites_id', 'page_no'];
        $req = new TbkUatmFavoritesItemGetRequest;
        $req->setFields('num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,click_url,seller_id,volume,category,coupon_click_url,coupon_end_time,coupon_info,coupon_start_time,coupon_total_count,coupon_remain_count,nick,shop_title,zk_final_price_wap,event_start_time,event_end_time,tk_rate,status,type');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 获取淘宝联盟选品库列表
     */
    public function taobaoTbkUatmFavoritesGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['page_no', 'page_size', 'type'];
        $req = new TbkUatmFavoritesGetRequest;
        $req->setFields('favorites_title,favorites_id,type');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘抢购api
     */
    public function taobaoTbkJuTqgGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['adzone_id', 'start_time', 'end_time', 'page_no', 'page_size'];
        $req = new TbkJuTqgGetRequest;
        $req->setFields('click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time,num_iid');
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 物料传播方式获取
     */
    public function taobaoTbkSpreadGet(String $url, bool $getCacheKeyInstead = false)
    {
        $req = new TbkSpreadGetRequest;
        $requests = new TbkSpreadRequest;
        $requests->url = $url;
        $req->setRequests(json_encode($requests));

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 聚划算商品搜索接口
     */
    public function taobaoJuItemsSearch(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['current_page', 'page_size', 'pid', 'postage', 'status', 'taobao_category_id', 'word'];
        $req = new JuItemsSearchRequest;
        $param_top_item_query = new TopItemQuery;
        $param_top_item_query = $this->setOptions->toOptions($req, $datas, $standard);
        $req->setParamTopItemQuery(json_encode($param_top_item_query));

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 好券清单API【导购】
     */
    public function taobaoTbkDgItemCouponGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['adzone_id', 'platform', 'cat', 'page_size', 'q', 'page_no'];
        $req = new TbkDgItemCouponGetRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 阿里妈妈推广券信息查询
     */
    public function taobaoTbkCouponGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $req = new TbkCouponGetRequest;
        if (!empty($datas['me'])) {
            $req->setMe($datas['me']);
        } else {
            $req->setItemId($datas['item_id']);
            $req->setActivityId($datas['activity_id']);
        }

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客淘口令
     */
    public function taobaoTbkTpwdCreate(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['user_id', 'text', 'url', 'logo', 'ext'];
        $req = new TbkTpwdCreateRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }


    /**
     * 淘宝客渠道信息备案 - 社交
     */
    public function taobaoTbkScPublisherInfoSave(string $session, array $data)
    {
        $standard = [
            'relation_from', 'offline_scene', 'online_scene', 'inviter_code', 'info_type',
            'note', 'register_info'
        ];
        $req = new TbkScPublisherInfoSaveRequest;
        $req = $this->setOptions->options($req, $data, $standard);
        return $this->c->execute($req, $session);
    }
    /**
     * 淘宝客信息查询 - 社交
     */
    public function taobaoTbkScPublisherInfoGet(string $session, array $data)
    {
        $standard = [
            'info_type', 'relation_id', 'page_no', 'page_size', 'relation_app', 'special_id'
        ];
        $req = new TbkScPublisherInfoGetRequest;
        $req = $this->setOptions->options($req, $data, $standard);
        return $this->c->execute($req, $session);
    }

    /**
     *  淘宝客邀请码生成-社交
     */
    public function taobaoTbkScInvitecodeGet(string $session, array $data)
    {
        $standard = [
            'relation_id', 'relation_app', 'code_type'
        ];
        $req = new TbkScInvitecodeGetRequest;
        $req = $this->setOptions->options($req, $data, $standard);
        return $this->c->execute($req, $session);
    }

    /**
     * 淘宝客【推广者】旧版订单查询
     */
    public function taobaoTbkOrderGet(array $datas)
    {
        $standard = [
            'span', 'page_no', 'page_size', 'tk_status', 'order_query_type',
            'order_scene', 'order_count_type', 'start_time'
        ];
        $req = new TbkOrderGetRequest;
        $req->setFields('tb_trade_parent_id,tb_trade_id,num_iid,item_title,item_num,price,pay_price,seller_nick,seller_shop_title,commission,commission_rate,unid,create_time,earning_time,tk3rd_pub_id,tk3rd_site_id,tk3rd_adzone_id,relation_id,tb_trade_parent_id,tb_trade_id,num_iid,item_title,item_num,price,pay_price,seller_nick,seller_shop_title,commission,commission_rate,unid,create_time,earning_time,tk3rd_pub_id,tk3rd_site_id,tk3rd_adzone_id,special_id,click_time');
        $req = $this->setOptions->options($req, $datas, $standard);
        return $this->c->execute($req);
    }

    /**
     * 淘宝客【推广者】所有订单查询
     */
    public function taobaoTbkOrderDetailsGet(array $datas)
    {
        $standard = [
            'query_type', 'position_index', 'page_size', 'member_type', 'tk_status',
            'end_time', 'start_time', 'jump_type', 'page_no', 'order_scene'
        ];
        $req = new TbkOrderDetailsGetRequest;
        $req = $this->setOptions->options($req, $datas, $standard);
        return $this->c->execute($req);
    }

    public function taobaoTopAuthTokenCreate(array $data)
    {
        $standard = [
            'code', 'uuid'
        ];
        $req = new TopAuthTokenCreateRequest;
        $req = $this->setOptions->options($req, $data, $standard);
        return $this->c->execute($req, null, TopClient::HTTPS_URL);
    }

    /**
     * 淘宝客新用户订单API--导购
     */
    public function taobaoTbkDgNewuserOrderGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['page_size', 'adzone_id', 'page_no', 'start_time', 'end_time', 'activity_id'];
        $req = new TbkDgNewuserOrderGetRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客新用户订单API--社交
     */
    public function taobaoTbkScNewuserOrderGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['page_size', 'adzone_id', 'page_no', 'site_id', 'start_time', 'end_time', 'activity_id'];
        $req = new TbkScNewuserOrderGetRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 通用物料搜索API
     */
    public function taobaoTbkScMaterialOptional(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['start_dsr', 'page_size', 'page_no', 'platform', 'end_tk_rate', 'start_tk_rate', 'end_price', 'start_price', 'is_overseas', 'is_tmall', 'sort', 'itemloc', 'cat', 'q', 'adzone_id', 'site_id', 'has_coupon', 'ip', 'include_rfd_rate', 'include_good_rate', 'include_pay_rate_30', 'need_prepay', 'need_free_shipment', 'npx_level'];
        $req = new TbkScMaterialOptionalRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 通用物料搜索API（导购）
     */
    public function taobaoTbkDgMaterialOptional(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['start_dsr', 'page_size', 'page_no', 'platform', 'end_tk_rate', 'start_tk_rate', 'end_price', 'start_price', 'is_overseas', 'is_tmall', 'sort', 'itemloc', 'cat', 'q', 'adzone_id', 'has_coupon', 'ip', 'include_rfd_rate', 'include_good_rate', 'include_pay_rate_30', 'need_prepay', 'need_free_shipment', 'npx_level'];
        $req = new TbkDgMaterialOptionalRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 拉新活动汇总API--导购
     */
    public function taobaoTbkDgNewuserOrderSum(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['page_size', 'adzone_id', 'page_no', 'site_id', 'activity_id'];
        $req = new TbkDgNewuserOrderSumRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 拉新活动汇总API--社交
     */
    public function taobaoTbkScNewuserOrderSum(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['page_size', 'adzone_id', 'page_no', 'site_id', 'activity_id'];
        $req = new TbkScNewuserOrderSumRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    // 淘口令基础包
    /**
     * 生成淘口令
     */
    public function taobaoWirelessShareTpwdCreate(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['user_id', 'text', 'url', 'logo', 'ext'];
        $req = new WirelessShareTpwdCreateRequest;
        $tpwd_param = new GenPwdIsvParamDto;
        $tpwd_param = $this->setOptions->toOptions($tpwd_param, $datas, $standard);
        $req->setTpwdParam(json_encode($tpwd_param));

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 查询解析淘口令
     */
    public function taobaoWirelessShareTpwdQuery(String $tpwd, bool $getCacheKeyInstead = false)
    {
        $req = new WirelessShareTpwdQueryRequest;
        $req->setPasswordContent($tpwd);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    // 淘宝客-工具-超级搜索    注：已经存在
    /**
     * 通用物料搜索API
     */
    // public function taobaoTbkScMaterialOptional(array $datas, bool $getCacheKeyInstead = false)
    // {
    // 	$standard = [];
    // 	$req = new TbkScMaterialOptionalRequest;
    // 	$req = $this->setOptions->options($req, $datas, $standard);

    // 	return $this->execRequest($req, $getCacheKeyInstead);
    // }

    /**
     * 淘客媒体内容输出
     */
    public function taobaoTbkContentGet(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['adzone_id', 'type', 'before_timestamp', 'count', 'cid', 'image_width', 'image_height', 'content_set'];
        $req = new TbkContentGetRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客擎天柱通用物料API
     */
    public function taobaoTbkDgOptimusMaterial(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['adzone_id', 'page_size', 'page_no', 'material_id', 'item_id'];
        $req = new TbkDgOptimusMaterialRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客擎天柱通用物料API
     */
    public function taobaoTbkScOptimusMaterial(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['adzone_id', 'page_size', 'page_no', 'material_id', 'site_id'];
        $req = new TbkScOptimusMaterialRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    // 淘宝客-媒体-单品券高效转链包
    /**
     * 【导购】链接转换
     */
    public function taobaoTbkCouponConvert(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['item_id', 'adzone_id', 'platform', 'me'];
        $req = new TbkCouponConvertRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    // 淘宝客链接API
    /**
     * 淘宝客商品链接转换
     */
    public function taobaoTbkItemConvert(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['num_iids', 'adzone_id', 'platform', 'unid', 'dx'];
        $req = new TbkItemConvertRequest;
        $req->setFields("num_iid,click_url");
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘宝客店铺链接转换
     */
    public function taobaoTbkShopConvert(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['user_ids', 'platform', 'adzone_id', 'unid'];
        $req = new TbkShopConvertRequest;
        $req->setFields("user_id,click_url");
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 淘口令转链
     */
    public function taobaoTbkTpwdConvert(array $datas, bool $getCacheKeyInstead = false)
    {
        $standard = ['password_content', 'adzone_id', 'dx'];
        $req = new TbkTpwdConvertRequest;
        $req = $this->setOptions->options($req, $datas, $standard);

        return $this->execRequest($req, $getCacheKeyInstead);
    }

    /**
     * 请求淘宝获取数据，或者生成缓存键
     *
     * @param object $req
     * @param bool   $getCacheKeyInstead
     *
     * @return  stdClass|string
     *
     * @throws Exception
     */
    protected function execRequest($req, bool $getCacheKeyInstead)
    {
        return $getCacheKeyInstead ? $this->c->getCacheKey($req) : $this->c->execute($req);
    }
}
