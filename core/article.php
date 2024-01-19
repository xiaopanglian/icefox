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
    $time = (int) substr($time, 0, 10);
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
?>