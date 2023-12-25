<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>

<?php $this->need('components/head.php'); ?>

<body>
    <div class="container w-full lg:3/4 xl:w-3/5">

        <div class="col-mb-12 col-8 p-2" id="main" role="main">
            <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
                <h1 class="text-[#00b894] text-2xl" itemprop="name headline">
                    <a itemprop="url" class="text-[#00b894] text-2xl no-underline" href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                </h1>
                <ul class="flex flex-row mt-4 mb-4 list-none list-outside p-0">
                    <li class="text-sm text-gray-600 mr-4"><?php _e('时间: '); ?>
                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
                    </li>
                </ul>
                <div class="mt-8 mb-8 leading-8" id="content">
                    <?php $this->content(); ?>
                </div>
            </article>

            <hr>

            <ul class="post-near list-none p-0 detail-next">
                <li>上一篇: <?php $this->thePrev('%s', '没有了'); ?></li>
                <li>下一篇: <?php $this->theNext('%s', '没有了'); ?></li>
            </ul>
        </div><!-- end #main-->

        <?php $this->need('comments.php'); ?>

        <!--footer部分-->
        <?php $this->need('footer.php'); ?>

    </div>
</body>

</html>