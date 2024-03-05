<?php
/**
 * 朋友圈Icefox主题
 * 全新版本，优化UI，优化交互
 * 示例站：<a href="http://0ru.cn" target="_blank">http://0ru.cn/</a>
 *
 * @package Icefox
 * @author 小胖脸
 * @version 1.6.1
 * @link http://xiaopanglian.com/
 */

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
?>

<?php $this->need('/components/header.php'); ?>


<div class="bg-white dark:bg-[#323232] dark:text-[#cccccc] mx-auto main-container" :class="{'dark':darkMode}">

    <?php $this->need('/components/option-header.php'); ?>

    <!-- 文章列表 -->
<?php
// 创建 Widget_Contents_Post 对象
$postWidget = new Widget_Contents_Post();
// 设置每页显示的文章数
$postWidget->pageSize = 5;
// 设置其他参数，例如排序方式
$postWidget->orderBy('created', Typecho_Db::SORT_DESC);
// 调用 render 方法输出文章列表
$postWidget->render();
// 遍历文章
while ($postWidget->next()) :
?>
    <div class="post">
        <h2><a href="<?php $postWidget->permalink() ?>"><?php $postWidget->title() ?></a></h2>
        <p><?php $postWidget->excerpt(100, '...') ?></p>
        <!-- 这里可以添加更多文章信息的输出 -->
    </div>
<?php endwhile; ?>

    <?php $this->need('/components/option-article-top.php'); ?>

    <div class="article-container">
        <?php while ($this->next()): ?>
            <?php $this->need('/components/option-article.php'); ?>
        <?php endwhile; ?>
    </div>
</div><!-- end #main-->

<?php $this->need('/components/footer.php'); ?>
