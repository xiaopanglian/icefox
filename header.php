<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<header class="container pb-8">
    <div class="">
        <?php if ($this->options->backgroundImageUrl): ?>
            <img src="<?php $this->options->backgroundImageUrl(); ?>" alt="top img" class="w-full object-cover" style="height: calc(100vh / 3) ;"/>
        <?php else: ?>
            <img src="http://localhost:8008/usr/uploads/2023/08/3063883109.jpg" alt="top img" class="w-full object-cover" style="height: calc(100vh / 3) ;"/>
        <?php endif; ?>
    </div>

    <div class="relative w-full">
        <div class="absolute right-0 bottom-[-16px] flex flex-row h-[64px] items-center w-full justify-end pr-8">
            <div class="text-white pr-5"><?php $this->options->nickName() ?></div>
            <img src="<?php $this->options->avatarUrl(); ?>" alt="logo" class="w-[64px] h-[64px] rounded-lg object-cover"/>
        </div>
    </div>


    <!--    <div class="grid grid-cols-12">-->
    <!--        <div class="col-span-6 h-24">-->
    <!--            <a id="logo" href="--><?php ////$this->options->siteUrl(); ?><!--" class="w-[200px]">-->
    <!--                <img src="http://localhost:8008/usr/uploads/2023/08/2589284162.png" alt="--><?php //$this->options->title() ?><!--" class="w-[200px]"/>-->
    <!--            </a>-->
    <!--                        --><?php //if ($this->options->logoUrl) : ?>
    <!--                            <a id="logo" href="--><?php //$this->options->siteUrl(); ?><!--">-->
    <!--                                <img src="--><?php //$this->options->logoUrl() ?><!--" alt="--><?php //$this->options->title() ?><!--" />-->
    <!--                            </a>-->
    <!--                        --><?php //else : ?>
    <!--                            <a id="logo" class="flex text-4xl h-16 items-center" href="--><?php //$this->options->siteUrl(); ?><!--">--><?php //$this->options->title() ?><!--</a>-->
    <!--                            <p class="w-">--><?php //$this->options->description() ?><!--</p>-->
    <!--                        --><?php //endif; ?>
    <!--        </div>-->
    <!--        <div class="col-span-6 flex justify-end items-center">-->
    <!--            <form id="search" method="post" action="--><?php //$this->options->siteUrl(); ?><!--" role="search" class="h-8 flex items-center">-->
    <!--                <label for="s" class="sr-only">--><?php //_e('搜索关键字'); ?><!--</label>-->
    <!--                <input type="text" id="s" name="s" class="outline-none border border-[#f59e0b] pl-2 pr-2 h-8 focus:outline-none m-0 w-[160px] focus:w-[260px] transition-all" placeholder="--><?php //_e('输入关键字搜索'); ?><!--"/>-->
    <!--                <button type="submit" class="h-8 border border-[#f59e0b] bg-[#f59e0b] text-white m-0 w-[60px] ">--><?php //_e('搜索'); ?><!--</button>-->
    <!--            </form>-->
    <!--        </div>-->
    <!---->
    <!--    </div>-->
    <!--    <div class="grid grid-cols-12">-->
    <!--        <div class="">-->
    <!--            --><?php //$this->need('components/menu.php'); ?>
    <!--        </div>-->
    <!--    </div>-->
</header>