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
 * Assistant 相关的接口.
 * //TODO @param string $instructions 系统人设指令:
 *-- 建议填写，能够提升模型的整体效果
 *-- 长度限制4096个字符，所有用户输入的token和需要小于4096
 *-- 默认配置在run的过程中可动态修改。
 *-- 概述Agent的整体功能和定位，需要它扮演一个什么样的"角色。
 *-- 1. 可以参考“你是xxx，你具有xx的特点，你可以做xxx，你需要满足用户xxx的需求”这样的结构。
 *-- 2. 可以指定一些与能力边界相关要求（对于哪些类型的问题，无法回答）
 *-- 示例：
 *-- 你是一个音乐智能语音助手，可以通过调用技能的方式满足用户听音乐，看电影，追剧，刷短视频，听有声读物，信息问答等需求。你无法提供与政治和政策相关的内容；当用户提出与音乐、视频等娱乐信息不相关的问题时，你需要委婉地拒绝用户。
 *
 * //TODO @param string $thought_instructions 思考规范:建议填写，能够提升模型的整体效果
 * -- 长度限制4096个字符，所有用户输入的token和需要小于4096
 * -- 默认配置在run的过程中可动态修改。
 * -- 与业务逻辑和规则相关的指令。希望模型遵守的行为规范和准则、要求都尽可能清晰、详尽地在这里给出描述。包括但不限于：
 * -- 在什么情况下需要调用什么工具；在调用xxx工具之前需要先调用xxx工具获取什么信息；
 * -- xxx工具填参的要求和偏好；（优先设定在工具描述中，如果较复杂，可以在这里强调）
 * -- 在模型判断结果无法满足用户时采取什么行动（换一个工具，或者改变参数调同一个工具，或是告知用户无法满足但努力基于当前信息提供结果，等）；
 * -- 示例：
 * -- 你需要遵循以下要求：
 * -- 1.当用户给出特定的歌曲名，或者给出特定歌手，或者给出特定风格的音乐时，优先调用music_player工具
 * -- 2.如果发现用户给出的是歌词，或者判断不出歌曲的名字、歌手时，请优先调用调用web_search工具获取歌名以及歌手，然后再去调用music_player工具
 * -- 3.当web_search返回结果存在内容错误、质量差、不相关、资源陈旧以及信息量不足等情况时，你可以尝试优化查询词并重新调用web_search。
 *
 * //TODO @param string $chat_instructions 回复规范
 * -- 建议填写，能够提升模型的整体效果
 * -- 长度限制4096个字符，所有用户输入的token和需要小于4096
 * -- 默认配置在run的过程中可动态修改
 * -- 与模型最终给出的回复内容相关的指令。包括但不限于：
 * -- 1. 语气偏好
 * -- 2. 回复格式要求
 * -- 3. 回复内容的丰富程度
 * -- 4. 开头和结尾的形式要求，例如在结尾时需要向用户提问引导话题深入进行
 * -- 示例：
 * -- 1.你需要对用户的需求和问题给予耐心细致的回应；根据用户的输入，灵活调整对话内容，确保对话流畅自然。
 * -- 2.当需要推荐电影给用户时，你需要按照以下格式输出：[电影名称](url)：推荐理由
 * -- 3.可以在回复中适当插入emoji表情，提升亲切感
 */
class Assistant extends BuilderClient
{
    private string $createPath = '/v2/assistants';

    private string $updatePath = '/v2/assistants/update';

    private string $listPath = '/v2/assistants/list';

    private string $queryPath = '/v2/assistants/query';

    private string $deletePath = '/v2/assistants/delete';

    private string $filePath = '/v2/assistants/files';

    private string $fileListPath = '/v2/assistants/files/list';

    private string $fileDeletePath = '/v2/assistants/files/delete';

    public function __construct(protected string $apiKey)
    {
        parent::__construct($apiKey);
    }

    /**
     * 创建Assistant.
     * @param string $model 模型名: 枚举- ERNIE-4.0-8K - ERNIE-3.5-custom-appbuilder
     * @param string $name assistant名:只允许中文，数字，大小写字母，下划线，中划线，最大长度为128个字符
     * @param string $description assistant描述:最大长度限制 512个字符
     * @param string $response_format 回复格式:枚举- text（默认）- json_object
     * @param array $tools 默认启用的工具列表:默认配置在run的过程中可动态修改,建议 <= 5个，整体挂载工具个数 <= 10
     * @param array $file_id 默认挂载的文件:默认配置在run的过程中可动态修改
     * @param array $metadata 元信息:一组可以附加到对象的16个键值对。这对于以结构化格式存储关于对象的附加信息非常有用。键的长度最多为64个字符，值的长度最多可为512个字符
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(string $model, string $name = '', string $description = '', string $response_format = 'text', string $instructions = '', string $thought_instructions = '', string $chat_instructions = '', array $tools = [], array $file_id = [], array $metadata = [])
    {
        return $this->request($this->createPath, json_encode(array_filter(compact('model', 'name', 'description', 'response_format', 'instructions', 'thought_instructions', 'chat_instructions', 'tools', 'file_id', 'metadata'))));
    }

    /**
     * 根据assistant_id修改一个已创建的Assistant.
     * @param int|string $assistant_id Assistant对象的id:创建assistant接口响应中的id字段的值
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(string|int $assistant_id, string $model = '', string $name = '', string $description = '', string $response_format = 'text', string $instructions = '', string $thought_instructions = '', string $chat_instructions = '', array $tools = [], array $file_id = [], array $metadata = [])
    {
        return $this->request($this->updatePath, json_encode(array_filter(compact('assistant_id', 'model', 'name', 'description', 'response_format', 'instructions', 'thought_instructions', 'chat_instructions', 'tools', 'file_id', 'metadata'))));
    }

    /**
     * 查询当前用户已创建的assistant列表.
     * @param int $limit 列举结果数量上限
     * @param string $order 排列顺序:创建时间进行排序，默认desc
     * @param string $after 查询指定assistant_id之后创建的Assistant
     * @param string $before 查询指定assistant_id之前创建的Assistant
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(int $limit = 20, string $order = 'desc', string $after = '', string $before = ''): string
    {
        return $this->request($this->listPath, json_encode(array_filter(compact('limit', 'order', 'after', 'before'))));
    }

    /**
     * 根据assistant_id查询Assistant信息.
     * @param string $assistant_id Assistant对象的id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function info(string $assistant_id)
    {
        return $this->request($this->queryPath, json_encode(array_filter(compact('assistant_id'))));
    }

    /**
     * 根据assistant_id删除指定Assitant.
     * @param string $assistant_id Assistant对象的id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function delete(string $assistant_id)
    {
        return $this->request($this->deletePath, json_encode(array_filter(compact('assistant_id'))));
    }

    /**
     * 指定file_id和assistant_id，挂载File到对应的Assistant .
     * @param string $assistant_id Assistant对象的id
     * @param string $file_id File对象的id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function files(string $assistant_id, string $file_id)
    {
        return $this->request($this->filePath, json_encode(array_filter(compact('assistant_id', 'file_id'))));
    }

    /**
     * 指定file_id和assistant_id，挂载File到对应的Assistant .
     * @param string $assistant_id Assistant对象的id
     * @param int $limit 列举结果数量上限
     * @param string $order 排列顺序:创建时间进行排序，默认desc
     * @param string $after 查询指定file_id之后创建的file_id列表
     * @param string $before 查询指定file_id之前创建的file_id列表
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function filesList(string $assistant_id, int $limit = 20, string $order = 'desc', string $after = '', string $before = '')
    {
        return $this->request($this->fileListPath, json_encode(array_filter(compact('assistant_id', 'limit', 'order', 'after', 'before'))));
    }

    /**
     * 指定assistant_id和file_id，解绑Assistant中对应File的关联 .
     * @param string $assistant_id Assistant对象的id
     * @param string $file_id File对象的id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function filesDelte(string $assistant_id, string $file_id)
    {
        return $this->request($this->fileDeletePath, json_encode(array_filter(compact('assistant_id', 'file_id'))));
    }
}
