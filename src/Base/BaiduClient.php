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

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use Tuoluojiang\BaidubceAppbuilder\Exception\BaiduBceException;

class BaiduClient
{
    private Client $client;

    private bool $verify = false;

    private Config $config;

    public function __construct(protected string $apiKey, protected ?LoggerInterface $logger = null)
    {
        $this->client = new Client(['verify' => $this->verify, 'timeout' => 10]);
        $this->config = new Config($apiKey);
    }

    /**
     * 发送请求
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function request(string $path, string $body = '', string $method = 'POST', bool $stream = false)
    {
        if ($stream) {
            $headers = $this->config->getStreamHeader()->getHeaders();
        } else {
            $headers = $this->config->getCommonHeader()->getHeaders();
        }
        $request = new Request($method, $this->config->getServiceUrl($path), $headers, $body);
        try {
            $response = $this->client->send($request);
            $response = json_decode($response->getBody()->getContents(), true);
            if (! $response) {
                throw new BaiduBceException('无响应', 500);
            }
            if ($response->getStatusCode() !== 200) {
                throw new BaiduBceException($response['message'], $response->getStatusCode());
            }
            $this->logger->info('BaidubceAppbuilder Info：', [
                'path'     => $path,
                'body'     => $body,
                'method'   => $method,
                'response' => $response,
            ]);
            return $response;
        } catch (\Exception $e) {
            $this->logger->error('BaidubceAppbuilder Error：' . $e->getMessage(), [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new BaiduBceException($e->getMessage());
        }
    }
}