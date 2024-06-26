<?php

declare(strict_types=1);
/**
 *  +----------------------------------------------------------------------
 *  | 陀螺匠 [ 赋能开发者，助力企业发展 ]
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2016~2024 https://www.tuoluojiang.com All rights reserved.
 *  +----------------------------------------------------------------------
 *  | Licensed 陀螺匠并不是自由软件，未经许可不能去掉陀螺匠相关版权
 *  +----------------------------------------------------------------------
 *  | Author: 陀螺匠 Team <admin@tuoluojiang.com>
 *  +----------------------------------------------------------------------
 */
namespace Tuoluojiang\BaidubceAppbuilder\Base;

use Tuoluojiang\BaidubceAppbuilder\Exception\BaiduBceException;

class Config
{
    private string $hostUrl = 'https://qianfan.baidubce.com';

    private string $builderUrl = 'https://appbuilder.baidu.com';

    /**
     * @param string $secretKey
     */
    public function __construct(protected string $secretKey)
    {
        if (! $secretKey) {
            throw new BaiduBceException('secret key is empty');
        }
    }

    /**
     * 获取请求地址
     */
    public function getServiceUrl(string $suffix): string
    {
        return $this->hostUrl . $suffix;
    }

    /**
     * 获取请求地址
     */
    public function getBuilderUrl(string $suffix): string
    {
        return $this->builderUrl . $suffix;
    }

    /**
     * 获取多媒体请求头.
     */
    public function getMultipartHeader(): HttpHeader
    {
        $header = $this->getCommonHeader();
        $header->addHeader('Content-Type', 'multipart/form-data;charset=utf-8');
        return $header;
    }

    /**
     * 获取公共请求头.
     */
    public function getCommonHeader(): HttpHeader
    {
        $header = new HttpHeader();
        $now    = new \DateTime();
        $header->addHeader('x-bce-date', 'x-bce-date:' . $now->format('Y-m-d\TH:i:s\Z'));
        $header->addHeader('Host', 'host: qianfan.baidubce.com');
        $header->addHeader('Content-Type', 'application/json;charset=utf-8');
        $header->addHeader('Authorization', 'Bearer ' . $this->secretKey);
        return $header;
    }
}
