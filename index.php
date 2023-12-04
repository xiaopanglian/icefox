<?php
/**
 * 朋友圈Icefox主题1.0版本
 * 全新版本，优化UI，优化交互
 * 示例站：<a href="http://0ru.cn" target="_blank">http://0ru.cn/</a>
 *
 * @package Icefox
 * @author 小胖脸
 * @version 1.0.1
 * @link http://0ru.cn
 */

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>

<?php $this->need('/components/header.php'); ?>


<div class="bg-white mx-auto main-container">

    <?php $this->need('/components/option-header.php'); ?>

    <div class="article-container">
        <?php while ($this->next()): ?>
            <?php $this->need('/components/option-article.php'); ?>
        <?php endwhile; ?>
    </div>
</div><!-- end #main-->

<?php $this->need('/components/footer.php'); ?>