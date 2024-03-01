<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>
<section class="fixed top-0 w-full">
    <div
        class="mx-auto main-container bg-white bg-opacity-50 dark:bg-black dark:bg-opacity-50 backdrop-filter backdrop-blur-lg h-[50px] flex justify-between items-center">
        <div class="ml-3">
            <span class="cursor-pointer">
                <img width="24" height="24" src="<?php $this->options->themeUrl('assets/svgs/music-play-light.svg'); ?>" />
            </span>
        </div>
        <div class="mr-3">
            <span>
                <img width="24" height="24" src="<?php $this->options->themeUrl('assets/svgs/link-light.svg'); ?>" />
            </span>
        </div>
    </div>

</section>