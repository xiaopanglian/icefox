<?php

/**
 * 根据文章id获取最新文章列表
 * @throws Exception
 */
function getArticleByCid($cid): array
{
    $db = Typecho_Db::get();
    $select = $db->select('table.contents.*,table.users.screenName')
        ->from('table.contents')
        ->join('table.users', 'table.contents.authorId = table.users.uid')
        ->where('cid = ?', $cid);
    return $db->fetchAll($select);
}

/**
 * 根据文章Id获取文章作者名称
 */
function _getUserScreenNameByCid($cid)
{
    $db = Typecho_Db::get();
    $select = $db->select('table.users.screenName')
        ->from('table.contents')
        ->join('table.users', 'table.contents.authorId = table.users.uid')
        ->where('cid = ?', $cid)
        ->limit(1);
    return $db->fetchRow($select);
}

/**
 * 根据文章id获取文章字段
 */
function getArticleFieldsByCid($cid, $name)
{
    $db = Typecho_Db::get();
    $select = $db->select('*')
        ->from('table.fields')
        ->where('cid = ?', $cid)
        ->where('name = ?', $name);
    return $db->fetchAll($select);
}

/**
 * 时间格式化
 */
function getTimeFormatStr($time)
{
    $time = (int)substr($time, 0, 10);
    $int = time() - $time;

    $str = '';
    if ($int <= 2) {
        $str = sprintf('刚刚', $int);
    } elseif ($int < 60) {
        $str = sprintf('%d秒前', $int);
    } elseif ($int < 3600) {
        $str = sprintf('%d分钟前', floor($int / 60));
    } elseif ($int < 86400) {
        $str = sprintf('%d小时前', floor($int / 3600));
    } elseif ($int < 1728000) {
        $str = sprintf('%d天前', floor($int / 86400));
    } else {
        $str = date('Y年m月d日', $time);
    }
    return $str;
}

/**
 * 移除 <img> 和 <video> 标签
 */
function removeImgAndVideoTags($html)
{

    $dom = new DOMDocument();
    // 启用 Tidy 修复（需安装 PHP Tidy 扩展）
    $tidyConfig = [
        'clean' => true,
        'output-html' => true,
        'show-body-only' => true,
        'wrap' => 0,
    ];
    $tidy = new tidy();
    $html = $tidy->repairString($html, $tidyConfig);
    // 预处理特殊符号进行转义
    $html = preg_replace('/&(?!(#[0-9]+|[a-z]+);)/i', '&amp;', $html);
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); // 处理中文编码

    // 移除标签，但保留内容
    getTagText($dom, 'h1');
    getTagText($dom, 'h2');
    getTagText($dom, 'h3');
    getTagText($dom, 'h4');
    getTagText($dom, 'h5');
    getTagText($dom, 'h6');
    getTagText($dom, 'strong');
    getTagText($dom, 'ul');
    getTagText($dom, 'li');
    getTagText($dom, 'blockquote');
    getTagText($dom, 'br');

    // 移除 <img>, <video> 标签
    removeTag($dom, 'img');
    removeTag($dom, 'video');

    return $dom->saveHTML();
}

/**
 * 移除标签，获取标签内容
 */
function getTagText($dom, $tagName)
{
    $strongElements = $dom->getElementsByTagName($tagName);
    $elementCount = $strongElements->length;
    while ($element = $strongElements->item(0)) {
        if ($element) {
            $strongContent = $element->textContent;
            $newNode = $dom->createTextNode($strongContent);
            if ($element->parentNode) {
                $element->parentNode->replaceChild($newNode, $element);
            }
        }
    }
}

/**
 * 移除标签
 */
function removeTag($dom, $tagName)
{
    $videos = $dom->getElementsByTagName($tagName);
    while ($video = $videos->item(0)) {
        $video->parentNode->removeChild($video); // 移除视频节点
    }
}

?>