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

/**
 * File 相关的接口.
 */
class File extends BuilderClient
{
    private string $listPath = '/v2/storage/files/list';

    private string $uploadPath = '/v2/storage/files';

    private string $infoPath = '/v2/storage/files/query';

    private string $deletePath = '/v2/storage/files/delete';

    private string $downloadPath = '/v2/storage/files/download';

    private string $contentPath = '/v2/storage/files/content';

    public function __construct(protected string $apiKey)
    {
        parent::__construct($apiKey);
    }

    /**
     * 上传文件，返回file_id.
     * @param mixed $file 基于form-data格式上传文件,form key需要为file，单次仅能上传一篇文档
     * @param string $purpose 文件用途,默认为assistant
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload(mixed $file, string $purpose = 'assistant')
    {
        return $this->request($this->uploadPath, json_encode(array_filter(compact('file'))), compact('purpose'), isMultipart: true);
    }

    /**
     * 查询文件列表.
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function list()
    {
        return $this->request($this->listPath);
    }

    /**
     * 根据file_id查询文件信息.
     * @param string $file_id File对象的id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function info(string $file_id)
    {
        return $this->request($this->infoPath, json_encode(array_filter(compact('file_id'))));
    }

    /**
     * 根据file_id删除一个已上传的文件.
     * @param string $file_id File对象的id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function delete(string $file_id)
    {
        return $this->request($this->deletePath, json_encode(array_filter(compact('file_id'))));
    }

    /**
     * 根据file_id下载一个已上传的文件.
     * @param string $file_id File对象的id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function download(string $file_id)
    {
        return $this->request($this->downloadPath, json_encode(array_filter(compact('file_id'))));
    }

    /**
     * 查看文件内容.
     * @param string $file_id File对象的id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function content(string $file_id)
    {
        return $this->request($this->contentPath, json_encode(array_filter(compact('file_id'))));
    }
}
