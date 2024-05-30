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

use Tuoluojiang\BaidubceAppbuilder\Base\BaiduClient;
use Tuoluojiang\BaidubceAppbuilder\Exception\BaiduBceException;

/**
 * 会话.
 */
class Conversation extends BaiduClient
{
    protected const CONVER_PATH = '/v2/app/conversation/runs';

    protected const INITIATE_PATH = '/v2/app/conversation';

    public function __construct(protected string $apiKey, protected string $appId)
    {
        parent::__construct($apiKey);
        if (! $this->appId) {
            throw new BaiduBceException('appId is null',500);
        }
    }

    /**
     * 大模型对话.
     * @param string $query 用户query文字， 长度限制2000字符
     * @param bool $stream 是否以流式接口的形式返回数据，默认false
     * @param string $conversation_id 对话id，可通过新建会话接口创建
     * @param array $fileIds 如果在对话中上传了文件，可以将文件id放入该字段，目前只处理第一个文件
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function run(string $query, bool $stream = false, string $conversation_id = '', array $fileIds = [])
    {
        if (! $conversation_id) {
            $conversation_id = $this->conversationId();
        }
        $app_id = $this->appId;
        return $this->request(self::CONVER_PATH, json_encode(compact('app_id', 'query', 'stream', 'conversation_id', 'fileIds')),stream: $stream);
    }

    /**
     * 新建会话.
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    protected function conversationId()
    {
        $response = $this->request(self::INITIATE_PATH, json_encode(['appid' => $this->appId]));
        return $response['conversation_id'];
    }
}
