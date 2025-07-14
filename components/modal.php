<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
?>

<!--友链弹出层-->
<div id="friend-modal" class="fixed top-0 left-0 w-full h-full backdrop-blur-md bg-black/50 z-90 hidden">
    <div
        class="fixed top-1/2 left-1/2 friend-container bg-white transform -translate-x-1/2 -translate-y-1/2 overflow-hidden">
        <div class="w-full flex flex-row justify-end">
            <div class="p-2">
                <img width="24" height="24" src="<?php $this->options->themeUrl('assets/svgs/btn-close.svg'); ?>"
                    class="cursor-pointer" onclick="closeFriendModal()" />
            </div>
        </div>
        <div class="px-5 py-3">
            <h2>友情链接</h2>
        </div>
        <div class="px-5 py-5">
            <?php
            $friendLinks = $this->options->friendLinks;
            if ($friendLinks) {
                $friendLinks_arr = preg_split('/\r\n|\n/', $friendLinks);
                foreach ($friendLinks_arr as $row) {
                    $fl = explode('||', $row);
                    ?>
                    <div class="mb-3 flex flex-row">
                        <img src="<?php echo $fl[0]; ?>" class="w-10 h-10 rounded-md mr-3" />
                        <a href="<?php echo $fl[2]; ?>"
                            class="text-sm font-semibold leading-6 text-gray-900 flex flex-row items-center cursor-pointer">
                            <?php echo $fl[1]; ?>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<!--音乐播放器-->
<div id="music-modal" class="fixed top-50 right-2 w-20 rounded-md overflow-hidden hidden">
    <div class="flex flex-col">
        <img src="" class="w-20 h-20 object-cover" id="fixed-music-cover" />
        <div class="bg-[#989997] flex flex-row justify-between">
            <div>
                <img width="24" height="24" src="<?php $this->options->themeUrl('assets/svgs/fixed-music-play.svg'); ?>"
                    class="cursor-pointer " id="fixed-music-play" />
                <img width="24" height="24" src="<?php $this->options->themeUrl('assets/svgs/fixed-music-pause.svg'); ?>"
                    class="cursor-pointer hidden" id="fixed-music-pause" />
            </div>
            <div>
                <img width="24" height="24"
                    src="<?php $this->options->themeUrl('assets/svgs/fixed-music-close.svg'); ?>" class="cursor-pointer"
                    id="fixed-music-close" />
            </div>
        </div>
    </div>
</div>