<nav id="nav-menu" class="clearfix" role="navigation">
    <a<?php if ($this->is('index')) : ?> class="current" <?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
        <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
        <?php while ($pages->next()) : ?>
            <a<?php if ($this->is('page', $pages->slug)) : ?> class="current" <?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
            <?php endwhile; ?>
</nav>