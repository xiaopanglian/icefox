<?php

/**
 * Icefox theme for Typecho
 *
 * @package Icefox Theme
 * @author XiaoPangLian
 * @version 0.1
 * @link http://typecho.org
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<!DOCTYPE HTML>
<html>

<?php $this->need('components/head.php'); ?>

<body>

<!--header部分-->
<?php $this->need('header.php'); ?>

<!--中间内容区-->
<div class="container grid grid-cols-12 gap-20">
    <div class="col-span-8">
        <div class="">
            <?php while ($this->next()) : ?>
                <article class="" itemscope itemtype="http://schema.org/BlogPosting">
                    <h2 class="text-xl mt-6 mb-2" itemprop="name headline">
                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished" class="underline text-[#f59e0b]"><?php $this->date('m.d'); ?></time>

                        <a itemprop="url" href="<?php $this->permalink() ?>" class="hover:text-[#f59e0b]"><?php $this->title() ?></a>
                    </h2>
                    <div class="text-sm pt-2 pb-4 text-slate-600" itemprop="articleBody">
                        <span class="bg-[#f59e0b] text-white pl-1 pr-1 mr-1"><?php $this->category(','); ?></span><?php $this->description(); ?>
                    </div>
<!--                    <ul class="flex flex-row gap-2 text-sm h-8 items-center">-->
<!--                        <li>-->
<!---->
<!--                        </li>-->
<!--                    </ul>-->
                </article>
            <?php endwhile; ?>

            <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
        </div><!-- end #main-->
    </div>

    <div class="col-span-4">
        <?php $this->need('sidebar.php'); ?>
    </div>
</div>
<!--footer部分-->
<?php $this->need('footer.php'); ?>
</body>

</html>