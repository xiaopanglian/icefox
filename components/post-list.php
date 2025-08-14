<?php

/**
 * 文章列表渲染组件
 * 
 * 功能：
 * - 处理置顶文章显示
 * - 处理普通文章列表
 * - 支持分页功能
 * - 提供文章显示参数
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

// 文章显示参数配置
$articleConfig = [
    'is_single' => $this->is('single'),
    'line_clamp' => $this->is('single') ? '' : 'line-clamp-4',
    'top_cids' => array_filter(explode('||', $this->options->topPost ?: '')),
    'current_page' => $this->widget('Widget_Archive@index', 'type=month&format=F Y')->currentPage
];

/**
 * 渲染置顶文章
 */
foreach ($articleConfig['top_cids'] as $cid) {
    try {
        $article = Helper::widgetById('Contents', $cid);
        if ($article && $article->have()) {
            $isTop = true;
            $isSingle = $articleConfig['is_single'];
            $lineClamp = $articleConfig['line_clamp'];
            include 'post-item.php';
        }
    } catch (Exception $e) {
        // 静默处理置顶文章加载错误
    }
}

/**
 * 渲染普通文章列表
 */
?>
<div class="article-container">
    <?php
    $postList = $this->widget('Widget_Archive', 'type=post', 'page=' . $articleConfig['current_page']);
    
    if ($postList->have()) {
        while ($postList->next()) {
            // 跳过置顶文章
            if (in_array($postList->cid, $articleConfig['top_cids'])) {
                continue;
            }
            
            $article = $postList;
            $isTop = false;
            $isSingle = $articleConfig['is_single'];
            $lineClamp = $articleConfig['line_clamp'];
            include 'post-item.php';
        }
    }
    ?>
</div>

<?php
// 分页导航（如果需要的话）
if (!$articleConfig['is_single'] && $this->getTotal() > $this->parameter->pageSize):
?>
<div class="pagination-container my-6 flex justify-center">
    <?php $this->pageNav('&laquo;', '&raquo;', 1, '...', array('wrapTag' => 'div', 'wrapClass' => 'page-navigator', 'itemTag' => 'span', 'textTag' => 'span')); ?>
</div>
<?php endif; ?>