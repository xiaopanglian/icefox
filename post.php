<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>

<?php $this->need('./components/head.php'); ?>

<body>

<!--header部分-->
<?php $this->need('header.php'); ?>


<!--中间内容区-->
<div class="container grid grid-cols-12 gap-20">
    <div class="col-span-8">
        <div class="" id="main" role="main">
            <article class="" itemscope itemtype="http://schema.org/BlogPosting">
                <h1 class="text-2xl hover:text-[#f59e0b]" itemprop="name headline">
                    <a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                </h1>
                <ul class="flex flex-row mt-4 mb-4">
                    <li><?php _e('时间: '); ?>
                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
                    </li>
                    <li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
                </ul>
                <div class="post-content" itemprop="articleBody">
                    <?php $this->content(); ?>
                </div>
                <p itemprop="keywords" class="tags"><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></p>
            </article>

            <?php $this->need('comments.php'); ?>

            <ul class="post-near">
                <li>上一篇: <?php $this->thePrev('%s', '没有了'); ?></li>
                <li>下一篇: <?php $this->theNext('%s', '没有了'); ?></li>
            </ul>
        </div><!-- end #main-->
    </div><!-- end #main-->


    <div class="col-span-4">
        <?php $this->need('sidebar.php'); ?>
    </div>
</div>
<!--footer部分-->
<?php $this->need('footer.php'); ?>
</body>

</html>