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
namespace Tuoluojiang\BaidubceAppbuilder\Util;

use Tuoluojiang\BaidubceAppbuilder\Exception\BaiduBceException;

class AssistantReq
{
    protected array $argument = [];

    public function __construct(protected array $params, protected string $scene = 'create')
    {
        $this->{$this->scene . 'Scene'}($params);
    }

    /**
     * 抛出错误.
     * @param array|string $message
     * @return BaiduBceException
     */
    public function exception(string|array $message, int $code = 0)
    {
        $message = is_array($message) ? json_encode($message) : $message;
        return new BaiduBceException($message, $code);
    }

    public function setValue($key, $value): void
    {
        $this->argument[$key] = $value;
    }

    public function getValues(): array
    {
        return $this->argument;
    }

    private function createScene($params): string
    {
        if (! isset($params['model']) || ! $params['model']) {
            throw $this->exception('缺少模型名称');
        }
        $this->setValue('model', $params['model']);
        if (isset($params['name']) && $params['name']) {
            $this->setValue('name', $params['name']);
        }
        if (isset($params['description']) && $params['description']) {
            $this->setValue('description', $params['description']);
        }
        $this->setValue('response_format', $params['response_format'] ?? 'text');
        $this->setValue('instructions', $params['instructions'] ?? 2000);
        $this->setValue('thought_instructions', $params['thought_instructions'] ?? 2000);
        $this->setValue('chat_instructions', $params['chat_instructions'] ?? 2000);
        $this->setValue('tools', $params['tools'] ?? []);
        $this->setValue('file_ids', $params['file_ids'] ?? []);
        $this->setValue('metadata', $params['metadata'] ?? []);
    }
}
