<?php
/**
 * 朋友圈Icefox主题
 * 全新V2版本，前端发布功能已上线，欢迎体验使用
 * 示例站：<a href="http://0ru.cn" target="_blank">http://0ru.cn/</a>
 *
 * @package icefox
 * @author 小胖脸
 * @version 2.0.2
 * @link http://xiaopanglian.com/
 */

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
?>

<?php $this->need('/components/header.php'); ?>


<div class="bg-white dark:bg-[#323232] dark:text-[#cccccc] mx-auto main-container" :class="{'dark':darkMode}">
    <?php $this->need('/components/option-header.php'); ?>

    <?php $this->need('/components/post-list-top.php'); ?>


    <?php // $this->need('/components/option-article-top.php');  ?>

    <div class="article-container">
        <?php $this->need('/components/post-list.php'); ?>
        <?php //while ($this->next()):  ?>
        <?php //$this->need('/components/option-article.php');  ?>
        <?php //endwhile;  ?>
    </div>
</div><!-- end #main-->

<?php $this->need('/components/modal.php'); ?>
<?php $this->need('/components/footer.php'); ?>