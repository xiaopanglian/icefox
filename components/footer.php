<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>

<div class="fixed left-10 bottom-10 text-gray-300 text-[12px] side-area side-area-left">
    <div class="flex flex-col"><div>Powered By <a href="https://xiaopanglian.com" class="cursor-pointer text-gray-300"
            target="_blank">Icefox Theme</a></div>
        <?php
        $beian = $this->options->beian;
        if (!empty($beian)) {
            echo '<a href="https://beian.miit.gov.cn/" class="cursor-pointer text-gray-300" target="_blank">' . $beian . '</a>';
        }
        $policeBeian = $this->options->policeBeian;
        if (!empty($policeBeian)) {
            $wbh = explode('||', $policeBeian);
            echo '<a href="' . $wbh[1] . '" class="cursor-pointer text-gray-300" target="_blank">' . $wbh[0] . '</a>';
        }
        ?>
    </div>
</div>
<div class="fixed right-10 bottom-10 side-area">
    <div
        class="w-[36px] h-[36px] cursor-pointer rounded-3xl bg-[#E8E9EC] hover:bg-[#DDDDDD] flex justify-center items-center mb-2">
        <img src="<?php $this->options->themeUrl('assets/svgs/btn-moon.svg'); ?>" class="cursor-pointer"
            @click="darkMode=true" x-show="darkMode==false" />
        <img src="<?php $this->options->themeUrl('assets/svgs/btn-sun.svg'); ?>" class="cursor-pointer"
            @click="darkMode=false" x-show="darkMode==true" />

    </div>
    <div class="w-[36px] h-[36px] cursor-pointer rounded-3xl bg-[#E8E9EC] hover:bg-[#DDDDDD] hidden"
        onclick="scrollToTop(); return false;" id="go-top">
        <div class="w-full h-full flex justify-center items-center">
            <img src="<?php $this->options->themeUrl('assets/svgs/btn-rocket.svg'); ?>" class="cursor-pointer" />
        </div>
    </div>
</div>
<div class="hidden" id="top-music-container">
    <?php
    $topMusics = $this->options->topMusicList;
    if ($topMusics) {
        $topMusic_arr = preg_split('/\r\n|\n/', $topMusics);
        foreach ($topMusic_arr as $row) {
            $fl = explode('||', $row);
            ?>
            <div data-id="<?php echo $fl[0]; ?>" data-cover="<?php echo $fl[1]; ?>"></div>
            <?php
        }
    }
    ?>
</div>

<div class="hidden px-2 py-2 first-of-type:pt-2">
    <div class="bg-white dark:bg-black/30 backdrop-blur-md"></div>
    <input class="webSiteHomeUrl" value="<?php echo getWebsiteHomeUrl(); ?>" />
    <input class="_currentPage" value="<?php if ($this->_currentPage > 1)
        echo $this->_currentPage;
    else
        echo 1; ?>" />
    <input class="_totalPage" value="<?php echo ceil($this->getTotal() / $this->parameter->pageSize); ?>" />
    <input id="commentsRequireMail" value="<?php echo $this->options->commentsRequireMail; ?>" />
    <input id="commentsRequireURL" value="<?php echo $this->options->commentsRequireURL; ?>" />
    <li>
        <div class="bg-white dark:bg-[#262626] p-2 rounded-sm border-1 border-solid border-[#07c160]">
            <div class="grid grid-cols-3 gap-2">
                <input placeholder="昵称"
                    class="border-0 outline-none bg-color-primary p-1 rounded-sm dark:bg-[#323232] dark:text-[#cccccc]" />
                <input placeholder="网址"
                    class="border-0 outline-none bg-color-primary p-1 rounded-sm dark:bg-[#323232] dark:text-[#cccccc]" />
                <input placeholder="邮箱"
                    class="border-0 outline-none bg-color-primary p-1 rounded-sm dark:bg-[#323232] dark:text-[#cccccc]" />
            </div>
            <div class="mt-2">
                <input placeholder="回复内容" class="border-0 outline-none w-full rounded-sm p-1 dark:text-[#cccccc]" />
            </div>
            <div class="flex justify-end mt-2">
                <div class="face mr-2 cursor-pointer"></div>
                <button
                    class="btn-comment bg-[#07c160] border-0 outline-none text-white cursor-pointer rounded-sm">回复</button>
            </div>
        </div>
    </li>
    <input id="observAutoPlayVideo" value="<?php echo $this->options->observAutoPlayVideo; ?>" />
    <div class="animate-spin"></div>
    <?php
    // 检查用户是否登录
    if ($this->user->hasLogin()) {
        // 用户已登录，获取用户信息
        $user = $this->user;
        $screenName = $user->screenName; // 用户昵称
        $mail = $user->mail; // 用户邮箱
        $url = $user->url; // 用户网址
    
        ?>
        <div id="login-is">1</div>
        <div id="login-screenName">
            <?php echo $screenName; ?>
        </div>
        <div id="login-mail">
            <?php echo $mail; ?>
        </div>
        <div id="login-url">
            <?php echo $url; ?>
        </div>
        <?php
    }
    ?>
</div>
</div>
</body>

</html>