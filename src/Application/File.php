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

class File extends BuilderClient
{
    private string $listPath = '/v2/storage/files/list';
    private string $uploadPath = '/v2/storage/files';

    public function __construct(protected string $apiKey)
    {
        parent::__construct($apiKey);
    }
}
