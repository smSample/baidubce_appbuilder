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
namespace Tuoluojiang\BaidubceAppbuilder\Application;

use Tuoluojiang\BaidubceAppbuilder\Base\BuilderClient;
use Tuoluojiang\BaidubceAppbuilder\Util\AssistantReq;

class Assistant extends BuilderClient
{
    private string $createPath = '/v2/assistants';

    public function __construct(protected string $apiKey)
    {
        parent::__construct($apiKey);
    }

    /**
     * 创建Assistant
     * @param AssistantReq $body
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(AssistantReq $body): string
    {
        return $this->request($this->createPath, json_encode($body->getValues()));
    }
}
