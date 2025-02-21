<?php

/**
 * 文章列表渲染
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$isSingle = false;
$lineClamp = 'line-clamp-4';// 内容超长时，显示全文和搜索按钮

if ($this->is('single')) {
    $isSingle = true;
    $lineClamp = '';
}
$topCids = explode('||', $this->options->topPost); // 置顶文章Id

// 页码
$currentPage = $this->widget('Widget_Archive@index', 'type=month&format=F Y')->currentPage;

/**
 * 置顶文章列表
 */
foreach ($topCids as $cid) {
    //    $article = (object)$this->widget('Widget_Archive@icefox' . $cid, 'pageSize=1&type=post', 'cid=' . $cid);
    if (trim($cid)) {
//        $article = $this->widget('Widget_Archive@icefox', [
//            'type' => 'post',
//            'cid' => $cid
//        ]);
        $article = Helper::widgetById('Contents',$cid);
//        print_r($article);
        $isTop = true;
        include 'post-item.php';
    }
}
?>

<div class="article-container">
    <?php
    // 当前文章列表
    $list = $this->widget('Widget_Archive', 'type=post', 'page=' . $currentPage);
    /**
     * 普通文章列表
     */
    foreach ($list->stack as $item) {
        $article = (object)$item;
        // 排除置顶文章
        if (in_array($article->cid, $topCids)) {
            continue;
        }
        $isTop = false;
        include 'post-item.php';
    }
    ?>
</div>