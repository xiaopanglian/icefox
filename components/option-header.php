<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>
<header class="h-77 w-full bg-cover relative mb-12"
    style="background-image: url('<?php echo $this->options->backgroundImageUrl ?>');background-position: center;">

    <div class="absolute right-6 bottom-[-40] flex flex-col items-end w-90%">
        <div class="flex flex-row items-end">
            <span class="text-white mr-5 mb-6"><?php echo $this->options->title ?></span>
            <div class="w-15 h-15 rounded-lg overflow-hidden">
                <img src="<?php echo $this->options->userAvatarUrl ?>" class="w-15 h-15 object-cover" />
            </div>
        </div>
        <div class="text-[12px] mt-3 text-gray truncate w-full text-end">
        <?php echo $this->options->description ?>
        </div>
    </div>

</header>