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

use GuzzleHttp\Exception\GuzzleException;
use Tuoluojiang\BaidubceAppbuilder\Base\BuilderClient;

/**
 * Thread 相关的接口.
 */
class Thread extends BuilderClient
{
    private string $createPath = '/v2/threads';

    private string $infoPath = '/v2/threads/query';

    private string $updatePath = '/v2/threads/update';

    private string $deletePath = '/v2/threads/delete';

    public function __construct(protected string $apiKey)
    {
        parent::__construct($apiKey);
    }

    /**
     * 创建Thread，返回对应的thread_id.
     * @param array $messages 本次对话追加的messages
     * @param array $metadata 一组可以附加到对象的16个键值对。这对于以结构化格式存储关于对象的附加信息非常有用。键的长度最多为64个字符，值的长度最多可为512个字符
     * @throws GuzzleException
     * @return mixed
     */
    public function create(array $messages, array $metadata = [])
    {
        return $this->request($this->createPath, json_encode(array_filter(compact('messages', 'metadata'))));
    }

    /**
     * 根据thread_id查询Thread对象的信息.
     * @param string $thread_id Thread对象的id
     * @throws GuzzleException
     * @return mixed
     */
    public function info(string $thread_id)
    {
        return $this->request($this->infoPath, json_encode(array_filter(compact('thread_id'))));
    }

    /**
     * 根据thread_id删除Thread对象
     * @param string $thread_id Thread对象的id
     *@throws GuzzleException
     * @return mixed
     */
    public function delete(string $thread_id)
    {
        return $this->request($this->deletePath, json_encode(array_filter(compact('thread_id'))));
    }

    /**
     * 根据thread_id，对thread进行修改.
     * @param string $thread_id Thread对象的id
     *@throws GuzzleException
     * @return mixed
     */
    public function update(string $thread_id, array $metadata = [])
    {
        return $this->request($this->updatePath, json_encode(array_filter(compact('thread_id', 'metadata'))));
    }
}
