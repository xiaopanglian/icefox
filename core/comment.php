<?php

/**
 * 根据文章id获取最新评论列表
 */
function getCommentByCid($cid, $parent = 0, $len = 5): array
{
    $db = Typecho_Db::get();
    $select = $db->select('coid,author,authorId,ownerId,mail,text,created,parent,url,cid')
        ->from('table.comments')
        ->where('cid = ?', $cid)
        ->where('parent = ?', $parent)
        ->where('status = ?', 'approved')
        ->order('created', Typecho_Db::SORT_DESC)
        ->limit($len);
    return $db->fetchAll($select);
}

/**
 * 根据文章id获取评论数量
 */
function getCommentCountByCid($cid){
    
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();

    $list = $db->fetchAll($db->select('cid')->from('table.comments')->where('cid = ?', $cid)->where('status = ?', 'approved'));
    $count = count($list);

    return $count;
}

/**
 * 获取点赞
 */
function getAgreeNumByCid($cid)
{
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();

    //  判断点赞数量字段是否存在
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
        //  在文章表中创建一个字段用来存储点赞数量
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }

    //  查询出点赞数量
    $agree = $db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $cid));
    //  获取记录点赞的 Cookie
    $AgreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    //  判断记录点赞的 Cookie 是否存在
    if (empty($AgreeRecording)) {
        //  如果不存在就写入 Cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array(0)));
    }

    //  返回
    return array(
        //  点赞数量
        'agree' => $agree['agree'],
        //  文章是否点赞过
        'recording' => in_array($cid, json_decode(Typecho_Cookie::get('typechoAgreeRecording'))) ? true : false
    );
}

/**
 * 是否点过赞
 */
function isAgreeByCid($cid)
{
    //  获取记录点赞的 Cookie
    $agreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    //  判断记录点赞的 Cookie 是否存在
    if (empty($agreeRecording)) {
        //  如果不存在就写入 Cookie
        return false;
    }
    //  把 Cookie 的 JSON 字符串转换为 PHP 对象
    $agreeRecordingDecode = json_decode($agreeRecording);
    //  判断文章是否点赞过
    if (in_array($cid, $agreeRecordingDecode)) {
        //  如果当前文章的 cid 在 cookie 中就返回文章的赞数，不再往下执行
        return true;
    }
    return false;
}

?>