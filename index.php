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
    <div class="container grid grid-cols-12 gap-6">
        <div class="col-span-9 bg-white">
            <div class="">
                <?php while ($this->next()) : ?>
                    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
                        <h2 class="post-title" itemprop="name headline">
                            <a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                        </h2>
                        <ul class="post-meta">
                            <li itemprop="author" itemscope itemtype="http://schema.org/Person"><?php _e('作者: '); ?><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></li>
                            <li><?php _e('时间: '); ?>
                                <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
                            </li>
                            <li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
                            <li itemprop="interactionCount">
                                <a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论', '1 条评论', '%d 条评论'); ?></a>
                            </li>
                        </ul>
                        <div class="post-content" itemprop="articleBody">
                            <!-- <?php $this->content('- 阅读剩余部分 -'); ?> -->
                        </div>
                    </article>
                <?php endwhile; ?>

                <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
            </div><!-- end #main-->
        </div>

        <div class="col-span-3 bg-white">
            <?php $this->need('sidebar.php'); ?>
        </div>
    </div>
    <!--footer部分-->
    <?php $this->need('footer.php'); ?>
</body>

</html>