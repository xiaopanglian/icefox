<?php

/**
 * Icefox theme for Typecho
 *
 * @package Icefox Theme
 * @author XiaoPangLian
 * @version 0.1
 * @link http://typecho.org
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<!DOCTYPE HTML>
<html>

<?php $this->need('components/head.php'); ?>

<body>
<!--http://localhost:8008/usr/uploads/2023/08/3063883109.jpg-->
<div class="container bg-white">
    <!--header部分-->
    <?php $this->need('header.php'); ?>
    <!--    时间<time datetime="--><?php //$this->date('c'); ?><!--" itemprop="datePublished" class="underline text-[#f59e0b]">--><?php //$this->date('m.d'); ?><!--</time>-->
    <!--中间内容区-->
    <div class="mt-6">
        <?php while ($this->next()) : ?>
            <article class="flex flex-row border-b borer-b-2 border-gray-200 pt-5 pb-5">
                <div class="w-16 lg:w-32 flex justify-end pr-2 lg:pr-5">
                    <img src="<?php $this->options->avatarUrl(); ?>" alt="" class="w-[32px] h-[32px] lg:w-[64px] lg:h-[64px] rounded-lg object-cover"/>
                </div>
                <div class="w-11/12 flex flex-col">
                    <!--作者-->
                    <div>
                        <span class="text-[#576b95]"><?php $this->options->nickName(); ?></span>
                    </div>

                    <!--内容-->
                    <div class="mt-3 mb-3">
                        <div class="text-[#1b1b1b]">
                            <?php $this->content(); ?>
                        </div>
                    </div>

                    <!--图片-->
                    <div class="w-11/12">
                        <?php
                        if ($this->fields->friend_pictures) {
                            $pictures = explode(',', $this->fields->friend_pictures);
                            $imgCount = count($pictures);
                            /*
                             * 不同数量图片，展示不同
                             */
                            if ($imgCount == 1) {
                                /*
                                 * 1张图片
                                 */
                                echo '<div class="grid grid-cols-1">';
                                echo '<img src="' . $this->fields->friend_pictures . '" alt="" class="max-w-full max-h-48 object-cover">';
                                echo '</div>';
                            } else if ($imgCount > 1) {
                                /*
                                 * 2、3、4、5、、7、8、9张
                                 */
                                echo '<div class="jgg-container">';
                                foreach ($pictures as $img) {
                                    echo '<div class="jgg-box"><div class="content"><img src="' . $img . '" alt="" class="w-full h-full object-cover"></div></div>';
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>

                    <!--时间-->
                    <div class="flex flex-row justify-between mt-3">

                        <div class="font-light text-gray-500 text-sm">
                            <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished" class=""><?php $this->dateWord(); ?></time>
                        </div>
                        <div class="relative">
                            <div class="comment-btn bg-[#F7F7F7] mr-5 flex justify-center rounded-sm cursor-pointer toggleCommentTip commentPoint">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full" viewBox="0 0 512 512" width="20" height="20" class="ml-2 mr-2">
                                    <g>
                                        <circle r="50" cy="255" cx="355" fill="#576b95"/>
                                        <circle r="50" cy="255" cx="155" fill="#576b95"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="absolute right-16 top-[-10px] bg-[#4b5153] flex flex-row justify-center items-center rounded-lg commentTip hidden">
                                <div class="flex flex-row justify-center items-center pl-5 pr-5 pt-2 pb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full"
                                         width="18" height="18" viewBox="0 0 512 512"
                                    >
                                        <path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                    </svg>
                                    <span class="text-white ml-1 mr-1">赞</span>
                                </div>
                                |
                                <div class="flex flex-row justify-center items-center ml-5 mr-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full"
                                         width="18" height="18" viewBox="0 0 512 512"
                                    >
                                        <path d="M408 64H104a56.16 56.16 0 00-56 56v192a56.16 56.16 0 0056 56h40v80l93.72-78.14a8 8 0 015.13-1.86H408a56.16 56.16 0 0056-56V120a56.16 56.16 0 00-56-56z" fill="none" stroke="#fff" stroke-linejoin="round" stroke-width="32"/>
                                    </svg>
                                    <span class="text-white whitespace-nowrap ml-1 mr-1">评论</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
        <div class="flex justify-center">
            下一页
        </div>
    </div>
    <!--footer部分-->
    <?php $this->need('footer.php'); ?>
</div>
</body>

</html>