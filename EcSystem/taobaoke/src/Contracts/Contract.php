<?php

namespace ES\Taobaoke\Contracts;

interface Contract
{
    // 淘宝客基础API
    /**
     * 淘宝客商品查询
     *
     * @param array $datas
     */
    public function taobaoTbkItemGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客商品查询
     *
     * @param array $datas
     */
    public function taobaoTbkItemRecommendGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客商品详情（简版）
     *
     * @param array $datas
     */
    public function taobaoTbkItemInfoGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客店铺查询
     *
     * @param array $datas
     */
    public function taobaoTbkShopGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客店铺关联推荐查询
     *
     * @param array $datas
     */
    public function taobaoTbkShopRecommendGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 枚举正在进行中的定向招商的活动列表
     *
     * @param array $datas
     */
    public function taobaoTbkUatmEventGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 获取淘宝联盟定向招商的宝贝信息
     *
     * @param array $datas
     */
    public function taobaoTbkUatmEventItemGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 获取淘宝联盟选品库的宝贝信息
     *
     * @param array $datas
     */
    public function taobaotbkUatmFavoritesItemGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 获取淘宝联盟选品库列表
     *
     * @param array $datas
     */
    public function taobaoTbkUatmFavoritesGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘抢购api
     *
     * @param array $datas
     */
    public function taobaoTbkJuTqgGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 物料传播方式获取
     *
     * @param string $url
     */
    public function taobaoTbkSpreadGet(String $url, bool $getCacheKeyInstead = false);

    /**
     * 聚划算商品搜索接口
     *
     * @param array $datas
     */
    public function taobaoJuItemsSearch(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 好券清单API【导购】
     *
     * @param array $datas
     */
    public function taobaoTbkDgItemCouponGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 阿里妈妈推广券信息查询
     *
     * @param array $datas
     */
    public function taobaoTbkCouponGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客淘口令
     *
     * @param array $datas
     */
    public function taobaoTbkTpwdCreate(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客新用户订单API--导购
     *
     * @param array $datas
     */
    public function taobaoTbkDgNewuserOrderGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客新用户订单API--社交
     *
     * @param array $datas
     */
    public function taobaoTbkScNewuserOrderGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 通用物料搜索API
     *
     * @param array $datas
     */
    public function taobaoTbkScMaterialOptional(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 通用物料搜索API（导购）
     *
     * @param array $datas
     */
    public function taobaoTbkDgMaterialOptional(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 拉新活动汇总API--导购
     *
     * @param array $datas
     */
    public function taobaoTbkDgNewuserOrderSum(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 拉新活动汇总API--社交
     *
     * @param array $datas
     */
    public function taobaoTbkScNewuserOrderSum(array $datas, bool $getCacheKeyInstead = false);

    // 淘口令基础包

    /**
     * 生成淘口令
     *
     * @param array $datas
     */
    public function taobaoWirelessShareTpwdCreate(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 查询解析淘口令
     *
     * @param string $tpwd
     */
    public function taobaoWirelessShareTpwdQuery(String $tpwd, bool $getCacheKeyInstead = false);

    // 淘宝客-工具-超级搜索    注：已经存在
    /**
     * 通用物料搜索API
     */
    // public function taobaoTbkScMaterialOptional(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘客媒体内容输出
     *
     * @param array $datas
     */
    public function taobaoTbkContentGet(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客擎天柱通用物料API
     *
     * @param array $datas
     */
    public function taobaoTbkDgOptimusMaterial(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客擎天柱通用物料API
     *
     * @param array $datas
     */
    public function taobaoTbkScOptimusMaterial(array $datas, bool $getCacheKeyInstead = false);

    // 淘宝客-媒体-单品券高效转链包

    /**
     * 【导购】链接转换
     *
     * @param array $datas
     */
    public function taobaoTbkCouponConvert(array $datas, bool $getCacheKeyInstead = false);

    // 淘宝客链接API

    /**
     * 淘宝客商品链接转换
     *
     * @param array $datas
     */
    public function taobaoTbkItemConvert(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘宝客店铺链接转换
     *
     * @param array $datas
     */
    public function taobaoTbkShopConvert(array $datas, bool $getCacheKeyInstead = false);

    /**
     * 淘口令转链
     *
     * @param array $datas
     */
    public function taobaoTbkTpwdConvert(array $datas, bool $getCacheKeyInstead = false);
}
