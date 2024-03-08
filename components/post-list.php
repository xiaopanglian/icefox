<?php
/**
 * 文章列表渲染
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$isSingle = false;
$lineClamp = 'line-clamp-4';

if ($this->is('single')) {
    $isSingle = true;
    $lineClamp = '';
}
?>


<?php

$currentPage = $this->widget('Widget_Archive@index', 'type=month&format=F Y')->currentPage;
echo $currentPage;
$list = $this->widget('Widget_Archive', 'type=post', 'page=' . $currentPage); ?>
<?php foreach ($list->stack as $item): ?>
    <?php print_r($list->cid); ?>


    <?php
endforeach;
?>