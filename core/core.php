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
}

/**
 * 获取网站首页地址。
 */
function getWebsiteHomeUrl()
{
    $rewrite = Helper::options()->rewrite;
    $tmpUrl = Helper::options()->siteUrl;
    if (!$rewrite) {
        $tmpUrl = $tmpUrl . 'index.php';
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
?>