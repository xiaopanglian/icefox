<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="" id="secondary" role="complementary">
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
        <section>
            <h3 class="text-lg mb-2"><?php _e('最新文章'); ?></h3>
            <ul class="">
                <?php \Widget\Contents\Post\Recent::alloc()
                    ->parse('<li><a href="{permalink}" class="text-sm text-gray-500 hover:text-[#f59e0b]">{title}</a></li>'); ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
        <section>
            <h3 class="text-lg mt-4 mb-2"><?php _e('最近回复'); ?></h3>
            <ul class="widget-list">
                <?php \Widget\Comments\Recent::alloc()->to($comments); ?>
                <?php while ($comments->next()): ?>
                    <li>
                        <a href="<?php $comments->permalink(); ?>" class="text-sm text-gray-500 hover:text-[#f59e0b]"><?php $comments->author(false); ?>: <?php $comments->excerpt(35, '...'); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
        <section>
            <h3 class="text-lg mt-4 mb-2"><?php _e('分类'); ?></h3>
            <ul>
                <?php $this->widget('Widget_Metas_Category_List')
                    ->parse('<li><a href="{permalink}" class="text-sm text-gray-500 hover:text-[#f59e0b]">{name} ({count})</a></li>'); ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
        <section>
            <h3 class="text-lg mt-4 mb-2"><?php _e('归档'); ?></h3>
            <ul>
                <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y-m-d')
                    ->parse('<li><a href="{permalink}" class="text-sm text-gray-500 hover:text-[#f59e0b]">{date}</a></li>'); ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
        <section>
            <h3 class="text-lg mt-4 mb-2"><?php _e('其它'); ?></h3>
            <ul class="widget-list">
                <?php if ($this->user->hasLogin()): ?>
                    <li class="text-sm text-gray-500 hover:text-[#f59e0b]"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?>
                            (<?php $this->user->screenName(); ?>)</a></li>
                    <li><a href="<?php $this->options->logoutUrl(); ?>" class="text-sm text-gray-500 hover:text-[#f59e0b]"><?php _e('退出'); ?></a></li>
                <?php else: ?>
                    <li class="text-sm text-gray-500 hover:text-[#f59e0b]"><a href="<?php $this->options->adminUrl('login.php'); ?>" class="text-sm text-gray-500 hover:text-[#f59e0b]"><?php _e('登录'); ?></a>
                    </li>
                <?php endif; ?>
                <li><a href="<?php $this->options->feedUrl(); ?>" class="text-sm text-gray-500 hover:text-[#f59e0b]"><?php _e('文章 RSS'); ?></a></li>
                <li><a href="<?php $this->options->commentsFeedUrl(); ?>" class="text-sm text-gray-500 hover:text-[#f59e0b]"><?php _e('评论 RSS'); ?></a></li>
            </ul>
        </section>
    <?php endif; ?>

</div><!-- end #sidebar -->
