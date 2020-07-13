<?php

namespace coldcolor\pay\wechat;

class Links
{
    //统一下单
    const CREATE_ORDER = "https://api.mch.weixin.qq.com/pay/unifiedorder";

    //订单查询
    const ORDER_QUERY = "https://api.mch.weixin.qq.com/pay/orderquery";

    //关闭订单
    const CLOSE_ORDER = "https://api.mch.weixin.qq.com/pay/closeorder";

    //申请退款
    const REFUND_ORDER = "https://api.mch.weixin.qq.com/secapi/pay/refund";

    //查询退款
    const REFUND_QUERY = "https://api.mch.weixin.qq.com/pay/refundquery";
}