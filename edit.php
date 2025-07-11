<?php

/**
 * 前端发布文章
 *
 * @package custom
 */
// 检查用户是否登录
if (!$this->user->hasLogin()) {
    // 用户未登录，跳转到登录页面
    // 设置 HTTP 重定向头  
    header('Location: /admin/');
    // 确保重定向后停止执行后续代码  
    exit;
}
$security = $this->widget('Widget_Security');
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>
        发布朋友圈 - <?php echo $this->options->title ?>
    </title>
    <!-- 使用url函数转换相关路径 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/style.css'); ?>?v=<?php echo __THEME_VERSION__; ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/viewer.min.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('uno.css'); ?>?v=<?php echo __THEME_VERSION__; ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/fancybox.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/plyr.css'); ?>">
    <style>
        <?php echo $this->options->css; ?>
    </style>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/jqueryui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/jquery.ui.touch.punch.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/axios.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/viewer.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/scrollload.min.js'); ?>"></script>
    <script defer src="<?php $this->options->themeUrl('assets/js/alpine.3.13.3.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/fancybox.umd.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/lazyload.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/anime.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/hls.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/Sortable.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/edit.js'); ?>?v=<?php echo __THEME_VERSION__; ?>"></script>
    <script type="text/javascript">
        <?php echo $this->options->script; ?>
    </script> <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
</head>

<body>
    <div class="bg-[#f0f0f0] dark:bg-[#262626]">
        <div style="min-height:100%">
            <form action="<?php $security->index('/action/contents-post-edit'); ?>" method="post" name="write_post">
                <div class="bg-white dark:bg-[#323232] dark:text-[#cccccc] mx-auto main-container">
                    <div class="h-14 bg-[#f0f0f0] flex flex-row justify-between items-center px-5">
                        <div class="">
                            <a href="/"><img src="<?php $this->options->themeUrl('assets/svgs/btn-left.svg'); ?>" class="w-[24px] h-[24px]" /></a>
                        </div>
                        <div>
                            <button class="btn-comment bg-[#07c160] border-0 outline-none text-white cursor-pointer rounded text-sm px-5 py-2">发表</button>
                        </div>
                    </div>
                    <div class="mt-2 px-5">
                        <textarea placeholder="这一刻的想法" class="w-full h-20 outline-none p-2 border-none resize-none border border-solid border-[#07c160]" name="text" id="text"></textarea>
                    </div>
                    <div class="mt-2 px-5">
                        <span class="bg-[#f0f0f0] p-3 rounded inline-flex cursor-pointer face-btn">
                            <img src="<?php $this->options->themeUrl('assets/svgs/smile.svg'); ?>" class="w-[18px] h-[18px] cursor-pointer" />
                        </span>
                    </div>
                    <div class="mt-2 px-5 face-container hidden" data-cid="${cid}" data-coid="${coid}">
                        <span class="cursor-pointer face-item">😀</span>
                        <span class="cursor-pointer face-item">😄</span>
                        <span class="cursor-pointer face-item">😁</span>
                        <span class="cursor-pointer face-item">😆</span>
                        <span class="cursor-pointer face-item">😅</span>
                        <span class="cursor-pointer face-item">😂</span>
                        <span class="cursor-pointer face-item">🤣</span>
                        <span class="cursor-pointer face-item">😊</span>
                        <span class="cursor-pointer face-item">😇</span>
                        <span class="cursor-pointer face-item">🙂</span>
                        <span class="cursor-pointer face-item">🙃</span>
                        <span class="cursor-pointer face-item">😉</span>
                        <span class="cursor-pointer face-item">😌</span>
                        <span class="cursor-pointer face-item">😍</span>
                        <span class="cursor-pointer face-item">🥰</span>
                        <span class="cursor-pointer face-item">😘</span>
                        <span class="cursor-pointer face-item">😗</span>
                        <span class="cursor-pointer face-item">😙</span>
                        <span class="cursor-pointer face-item">😚</span>
                        <span class="cursor-pointer face-item">😋</span>
                        <span class="cursor-pointer face-item">😛</span>
                        <span class="cursor-pointer face-item">😝</span>
                        <span class="cursor-pointer face-item">😜</span>
                        <span class="cursor-pointer face-item">🤪</span>
                        <span class="cursor-pointer face-item">🤨</span>
                        <span class="cursor-pointer face-item">🧐</span>
                        <span class="cursor-pointer face-item">🤓</span>
                        <span class="cursor-pointer face-item">😎</span>
                        <span class="cursor-pointer face-item">🤩</span>
                        <span class="cursor-pointer face-item">🥳</span>
                        <span class="cursor-pointer face-item">😏</span>
                        <span class="cursor-pointer face-item">😒</span>
                        <span class="cursor-pointer face-item">😞</span>
                        <span class="cursor-pointer face-item">😔</span>
                        <span class="cursor-pointer face-item">😟</span>
                        <span class="cursor-pointer face-item">😕</span>
                        <span class="cursor-pointer face-item">🙁</span>
                        <span class="cursor-pointer face-item">☹️</span>
                        <span class="cursor-pointer face-item">😣</span>
                        <span class="cursor-pointer face-item">😖</span>
                        <span class="cursor-pointer face-item">😫</span>
                        <span class="cursor-pointer face-item">😩</span>
                        <span class="cursor-pointer face-item">🥺</span>
                        <span class="cursor-pointer face-item">😢</span>
                        <span class="cursor-pointer face-item">😭</span>
                        <span class="cursor-pointer face-item">😤</span>
                        <span class="cursor-pointer face-item">😠</span>
                        <span class="cursor-pointer face-item">😡</span>
                        <span class="cursor-pointer face-item">🤬</span>
                        <span class="cursor-pointer face-item">🤯</span>
                        <span class="cursor-pointer face-item">😳</span>
                        <span class="cursor-pointer face-item">🥵</span>
                        <span class="cursor-pointer face-item">🥶</span>
                        <span class="cursor-pointer face-item">😱</span>
                        <span class="cursor-pointer face-item">😨</span>
                        <span class="cursor-pointer face-item">😰</span>
                        <span class="cursor-pointer face-item">😥</span>
                        <span class="cursor-pointer face-item">😓</span>
                        <span class="cursor-pointer face-item">🤗</span>
                        <span class="cursor-pointer face-item">🤔</span>
                        <span class="cursor-pointer face-item">🤭</span>
                        <span class="cursor-pointer face-item">🤫</span>
                        <span class="cursor-pointer face-item">🤥</span>
                        <span class="cursor-pointer face-item">😶</span>
                        <span class="cursor-pointer face-item">😐</span>
                        <span class="cursor-pointer face-item">😑</span>
                        <span class="cursor-pointer face-item">😬</span>
                        <span class="cursor-pointer face-item">🙄</span>
                        <span class="cursor-pointer face-item">😯</span>
                        <span class="cursor-pointer face-item">😦</span>
                        <span class="cursor-pointer face-item">😧</span>
                        <span class="cursor-pointer face-item">😮</span>
                        <span class="cursor-pointer face-item">😲</span>
                        <span class="cursor-pointer face-item">🥱</span>
                        <span class="cursor-pointer face-item">😴</span>
                        <span class="cursor-pointer face-item">🤤</span>
                        <span class="cursor-pointer face-item">😪</span>
                        <span class="cursor-pointer face-item">😵</span>
                        <span class="cursor-pointer face-item">🤐</span>
                        <span class="cursor-pointer face-item">🥴</span>
                        <span class="cursor-pointer face-item">🤢</span>
                        <span class="cursor-pointer face-item">🤮</span>
                        <span class="cursor-pointer face-item">🤧</span>
                        <span class="cursor-pointer face-item">😷</span>
                        <span class="cursor-pointer face-item">🤒</span>
                        <span class="cursor-pointer face-item">🤕</span>
                    </div>
                    <div class="flex flex-col px-5 gap-3">
                        <hr />
                        <div class="grid grid-cols-3 gap-3" id="sortgrid">
                            <!-- <div class="bg-[#f0f0f0] w-full aspect-square td relative">
                                <img src="http://icefox.com/usr/uploads/2024/06/2368640016.jpg"
                                    class="w-full h-full object-cover td" />
                                <div class="absolute right-3 top-3">
                                    <img src="<?php $this->options->themeUrl('assets/svgs/x.svg'); ?>"
                                        class="w-[18px] h-[18px] cursor-pointer bg-[#f0f0f0] rounded-full btn-img-remove" />
                                </div>
                            </div> -->
                        </div>

                        <div class="grid grid-cols-3 gap-3" id="sortgrid">
                            <input type="file" id="imageUpload" class="hidden" multiple />
                            <div class="bg-[#f0f0f0] w-full aspect-square flex justify-center items-center cursor-pointer new-plus no-sort">
                                <img src="<?php $this->options->themeUrl('assets/svgs/plus.svg'); ?>" class="w-[18px] h-[18px] cursor-pointer" />
                            </div>
                        </div>

                        <input type="hidden" name="fields[friend_pictures]" id="friend_pictures" />
                    </div>
                    <div class="px-5">
                        <hr />
                        <div class="flex flex-row items-center gap-3">
                            <img src="<?php $this->options->themeUrl('assets/svgs/position.svg'); ?>" class="w-[18px] h-[18px]" />
                            <input placeholder="所在位置" class="py-2 px-2 w-full outline-none border border-solid border-[#07c160]" name="fields[position]" />
                        </div>
                    </div>
                    <div class="px-5">
                        <hr />
                        <div class="flex flex-row items-center gap-3">
                            <img src="<?php $this->options->themeUrl('assets/svgs/position-link.svg'); ?>" class="w-[18px] h-[18px]" />
                            <input placeholder="定位跳转地址" class="py-2 px-2 w-full outline-none border border-solid border-[#07c160]" name="fields[positionUrl]" />
                        </div>
                    </div>
                    <div class="pb-5 px-5">
                        <hr />
                        <div class="flex flex-row justify-between py-2 ad-container">
                            <div class="flex gap-3">
                                <div class="text-xs border border-solid border-[#999]">AD</div>
                                <div class="">是否广告</div>
                            </div>
                            <div class="cursor-pointer ad-status">
                                否
                            </div>
                            <input type="hidden" name="fields[isAdvertise]" id="isAdvertise" value="0" />
                        </div>
                    </div>
                </div><!-- end #main-->

                <input type="hidden" name="visibility" value="publish" />
                <input type="hidden" name="do" value="publish" />
                <input type="hidden" name="timezone" value="28800" />
                <input type="hidden" name="allowComment" value="1" />
                <input type="hidden" name="allowPing" value="1" />
                <input type="hidden" name="allowFeed" value="1" />
                <input type="hidden" name="markdown" value="1" />
                <input type="hidden" name="title" value="<?php echo date('Y-m-d H:i:s'); ?>" />

            </form>
        </div>
    </div>

    <input type="hidden" value="<?php $this->options->themeUrl('assets/svgs/x.svg'); ?>" id="xsvg" />
</body>

</html>