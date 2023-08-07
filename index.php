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
                <div class="w-32 flex justify-end pr-5">
                    <img src="http://localhost:8008/usr/uploads/2023/08/2728746032.png" alt="" class="w-[64px] h-[64px] rounded-lg"/>
                </div>
                <div class="w-11/12">
                    <!--作者-->
                    <div>
                        <span class="text-[#576b95]"><?php $this->author(); ?></span>
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
                                echo '<div class=""><div class="grid grid-cols-10 gap-1">';
                                foreach ($pictures as $img) {
                                    echo '<div class="col-span-3"><img src="' . $img . '" alt="" class="icefox-img w-full h-0 object-cover"></div>';
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
                        <div>
                            <div class="comment-btn w-10 bg-[#F7F7F7] mr-5 flex justify-center rounded-sm cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full"
                                     width="20" height="20" viewBox="0 0 512 512"
                                >
                                    <g>
                                        <circle r="50" cy="255" cx="355" fill="#576b95"/>
                                        <circle r="50" cy="255" cx="155" fill="#576b95"/>
                                    </g>
                                </svg>
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