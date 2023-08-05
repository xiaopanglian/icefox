<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="container">
    <div class="grid grid-cols-12">
        <div class="col-span-2">
            <a id="logo" href="<?php //$this->options->siteUrl(); ?>" class="w-[200px]">
                <img src="http://localhost:8008/usr/uploads/2023/08/2589284162.png" alt="<?php $this->options->title() ?>" class="w-[200px]"/>
            </a>
            <!--            --><?php //if ($this->options->logoUrl) : ?>
            <!--                <a id="logo" href="--><?php //$this->options->siteUrl(); ?><!--">-->
            <!--                    <img src="--><?php //$this->options->logoUrl() ?><!--" alt="--><?php //$this->options->title() ?><!--" />-->
            <!--                </a>-->
            <!--            --><?php //else : ?>
            <!--                <a id="logo" class="text-4xl" href="--><?php //$this->options->siteUrl(); ?><!--">--><?php //$this->options->title() ?><!--</a>-->
            <!--                <p class="description">--><?php //$this->options->description() ?><!--</p>-->
            <!--            --><?php //endif; ?>
        </div>
        <div class="col-span-10 flex justify-end items-center">
            <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
                <input type="text" id="s" name="s" class="outline-none border-2 border-blue-300 h-8 focus:outline-none m-0 w-[100px] focus:w-[200px] transition-all" placeholder="<?php _e('输入关键字搜索'); ?>"/>
                <button type="submit" class="h-8 border-2 border-blue-300 bg-gray-50 m-o w-[60px]"><?php _e('搜索'); ?></button>
            </form>
        </div>

    </div><!-- end .row -->
    <div class="grid grid-cols-12">
        <div class="">
            <?php $this->need('components/menu.php'); ?>
        </div>
    </div>
</div>