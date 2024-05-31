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

class HttpHeader
{
    public function __construct(protected array $headers = [])
    {
    }

    /**
     * 新增头信息.
     * @param $name
     * @param $value
     */
    public function addHeader($name, $value): void
    {
        $this->headers[$name] = $value;
    }

    /**
     * 获取头信息.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * 获取单个头信息.
     * @param $name
     */
    public function getHeader($name): string
    {
        return $this->headers[$name];
    }
}
