<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>
<header class="h-77 w-full bg-cover relative mb-12"
    style="background-image: url('<?php echo $this->options->backgroundImageUrl ?>');background-position: center;">
    <div class="fixed top-0 left-0 w-full h-14 z-9">
        <div class="main-container mx-auto flex flex-row justify-between h-full transition-all duration-300"
            id="top-fixed">
            <div class="flex items-center">
                <span class="h-full px-5 flex items-center">
                    <?php
                    if ($this->is('single')) {
                        ?>
                        <img width="24" height="24"
                            src="<?php $this->options->themeUrl('assets/svgs/post.top.back.svg'); ?>"
                            class="cursor-pointer <?php echo $this->options->defaultThemeColor == 'yes' ? "hidden" : ""; ?> go-back mr-3"
                            id="back-light" />
                        <img width="24" height="24"
                            src="<?php $this->options->themeUrl('assets/svgs/post.top.back.dark.svg'); ?>"
                            class="cursor-pointer <?php echo $this->options->defaultThemeColor == 'yes' ? "" : "hidden"; ?> go-back mr-3"
                            id="back-dark" />
                        <?php
                    }
                    ?>
                    <div id="top-play">
                        <img width="24" height="24" src="<?php $this->options->themeUrl('assets/svgs/btn-play.svg'); ?>"
                            class="top-play cursor-pointer <?php echo $this->options->defaultThemeColor == 'yes' ? "hidden" : ""; ?>"
                            id="top-play-light" />
                        <img width="24" height="24"
                            src="<?php $this->options->themeUrl('assets/svgs/btn-play.dark.svg'); ?>"
                            class="top-play cursor-pointer <?php echo $this->options->defaultThemeColor == 'yes' ? "" : "hidden"; ?>"
                            id="top-play-dark" />
                    </div>

                    <div id="top-pause" class="hidden">
                        <img width="24" height="24"
                            src="<?php $this->options->themeUrl('assets/svgs/btn-pause.svg'); ?>"
                            class="top-pause cursor-pointer <?php echo $this->options->defaultThemeColor == 'yes' ? "hidden" : ""; ?>"
                            id="top-pause-light" />
                        <img width="24" height="24"
                            src="<?php $this->options->themeUrl('assets/svgs/btn-pause.dark.svg'); ?>"
                            class="cursor-pointer <?php echo $this->options->defaultThemeColor == 'yes' ? "" : "hidden"; ?>"
                            id="top-pause-dark" />
                    </div>
                    <div id="top-music-progress" class="ml-3">
                        <div class="relative h-[3px] w-10 bg-[A2A3A1]">
                            <div class="absolute h-[1px] w-0 left-0 top-[1px] bg-white" id="top-music-jdt"></div>
                        </div>
                    </div>
                </span>
            </div>
            <div class="flex items-center">
                <span class="h-full px-5 flex items-center">
                    <img width="24" height="24"
                        src="<?php $this->options->themeUrl('assets/svgs/header.friend.svg'); ?>"
                        class="cursor-pointer <?php echo $this->options->defaultThemeColor == 'yes' ? "hidden" : ""; ?> "
                        @click="showFriendModal()" id="friend-light" />
                    <img width="24" height="24"
                        src="<?php $this->options->themeUrl('assets/svgs/header.friend.dark.svg'); ?>"
                        class="cursor-pointer <?php echo $this->options->defaultThemeColor == 'yes' ? "" : "hidden"; ?>"
                        @click="showFriendModal()" id="friend-dark" />
                </span>
            </div>
        </div>
    </div>
    <div class="absolute right-6 bottom-[-40] flex flex-col items-end w-90%">
        <div class="flex flex-row items-end">
            <span class="text-white mr-5 mb-6"><a href="<?php echo $this->options->about; ?>"
                    class="text-white cursor-pointer no-underline"><?php echo $this->options->avatarTitle; ?></a></span>
            <div class="w-15 h-15 rounded-lg overflow-hidden">
                <a href="/" class="cursor-pointer w-full h-full"><img src="<?php echo $this->options->userAvatarUrl ?>"
                        class="w-15 h-15 object-cover cursor-pointer" /></a>
            </div>
        </div>
        <div class="text-[12px] mt-3 text-gray truncate w-full text-end">
            <?php echo $this->options->description ?>
        </div>
    </div>

</header>