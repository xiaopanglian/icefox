<?php

// 内置接口
include_once 'api.php';
// 文章方法
include_once 'article.php';
// 评论方法
include_once 'comment.php';

// 主题初始化
function themeInit($self)
{
    $route = $self->request->getPathInfo();

    /* 主题开放API 路由规则 */
    if ($self->request->isPost()) {
        switch ($route) {
            case '/api/comment':
                addComment($self);
                break;
            case '/api/like':
                addAgree($self);
                break;
        }
    }

    switch ($route) {
        case '/api/music':
            getMusicUrl($self);
            break;
    }
}

/**
 * 获取网站首页地址。
 */
function getWebsiteHomeUrl()
{
    $rewrite = Helper::options()->rewrite;
    $tmpUrl = Helper::options()->siteUrl;
    if (!$rewrite) {
        $tmpUrl = $tmpUrl . 'index.php/';
    }
    return $tmpUrl;
}

/**
 * 查找数组选项值，无法获取则返回默认值
 * @param $optionName     名称
 * @param $searchName   数组名
 * @param $defaultValue 默认值
 */
function inArrayOptionValueOrDefault($optionName, $searchName, $defaultValue)
{
    if ($optionValue = Helper::options()->$optionName) {
        return in_array($searchName, $optionValue);
    } else {
        return $defaultValue;
    }
}

/**
 * 获取内容里面的图片
 */
function getAllImages($content)
{
    $imgs = [];

    if (empty($content)) {
        return $imgs;
    }
    // 创建DOM对象
    $dom = new DOMDocument();
    @$dom->loadHTML($content); // @符号表示忽略错误信息

    // 查找所有的img元素节点
    $images = $dom->getElementsByTagName('img');
    if ($images->length > 0) {
        // 输出所有img标签的src属性值
        foreach ($images as $image) {
            array_push($imgs, $image->getAttribute('src'));
        }
    }

    return $imgs;
}
