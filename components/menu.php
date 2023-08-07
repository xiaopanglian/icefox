<nav class="h-16 flex items-center gap-5">
    <a class="<?php if ($this->is('index')) : ?> text-[#f59e0b] <?php endif; ?> text-xl" href="<?php $this->options->siteUrl(); ?>">
        <?php _e('首页'); ?>
    </a>
    <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
    <?php while ($pages->next()) : ?>
        <a class="<?php if ($this->is('page', $pages->slug)) : ?> text-blue-300 <?php endif; ?> text-xl" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>">
            <?php $pages->title(); ?>
        </a>
    <?php endwhile; ?>
</nav>