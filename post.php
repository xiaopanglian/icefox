<?php
// 详情页
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>

<?php $this->need('/components/header.php'); ?>


<?php $this->need('/components/single-top.php'); ?>
<div class="bg-white dark:bg-[#323232] dark:text-[#cccccc] mx-auto main-container">

    <?php $this->need('/components/option-header.php'); ?>

    <div class="article-container">
        <?php $this->need('/components/option-article.php'); ?>
    </div>
</div><!-- end #main-->

<?php $this->need('/components/single-footer.php'); ?>