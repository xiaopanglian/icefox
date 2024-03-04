<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$isSingle = false;
$lineClamp = 'line-clamp-4';

if ($this->is('single')) {
    $isSingle = true;
    $lineClamp = '';
}
?>

<article class="flex flex-row border-b borer-b-2 dark:border-gray-600 border-gray-200 pt-5 pl-5 pr-5">
    <div class="mr-3">
        <div class="w-9 h-9">
            <img src="<?php echo $this->options->userAvatarUrl ?>" class="w-9 h-9 object-cover rounded-lg" />
        </div>
    </div>
    <div class="w-full border-t-0 border-l-0 border-r-0 border-b-1 dark:border-gray-600 border-gray-100 border-solid">
        <section class="flex flex-row justify-between items-center">
            <span class="text-color-link cursor-default text-[14px]">
                <?php $this->author(); ?>
            </span>
            <?php $isAdvertise = $this->fields->isAdvertise;
            if ($isAdvertise == true):
                ?>
                <span class="text-[12px] bg-[#f0f0f0] dark:bg-[#262626] p-1 text-[#c6c6c6] rounded-sm">广告</span>
            <?php endif; ?>
        </section>
        <section
            class="cursor-default text-[14px] article-content break-all <?php echo $lineClamp; ?> content-<?php echo $this->cid; ?>"
            data-cid="<?php echo $this->cid; ?>">
            <?php
            $clearContent = preg_replace('/<img[^>]+>/i', '', $this->content);
            $clearContent = preg_replace('/<br><br>/i', '', $clearContent);
            echo $clearContent;
            ?>
        </section>
        <?php
        if (!$isSingle) {
            ?>
            <div class="text-[14px] text-color-link cursor-pointer qw qw-<?php echo $this->cid; ?> hidden"
                data-cid="<?php echo $this->cid; ?>">全文</div>
            <div class="text-[14px] text-color-link cursor-pointer ss ss-<?php echo $this->cid; ?> hidden"
                data-cid="<?php echo $this->cid; ?>">收缩</div>
            <?php
        }
        ?>
        
        <?php 
            $music = $this->fields->music;
            if(!empty($music)){
				$musicArr = $friendPictures = explode('||', $music);
                ?>
                    <div class="w-full">
                        <figure class="flex overflow-hidden rounded-sm h-[80px] w-[calc(66.66%)] m-0 bg-cover bg-center "  style="background-image: url('<?php echo $musicArr[3]; ?>')">
							<div class="w-full h-full bg-cover bg-center backdrop-blur-lg backdrop-filter bg-opacity-50 flex flex-row relative">
								<img src="<?php echo $musicArr[3]; ?>" class="h-full w-auto aspect-square object-cover rounded-full music-img" id="music-img-<?php echo $this->cid; ?>" rotate="rotate-animation" />
								<div class="flex flex-col text-white p-2">
									<span class="mt-1"><?php echo $musicArr[0]; ?></span>
									<span class="mt-1"><?php echo $musicArr[1]; ?></span>
								</div>
								<div class="absolute right-3 top-5">
									<img width="36" height="36" src="<?php $this->options->themeUrl('assets/svgs/music-play-light.svg'); ?>" @click="playAudio(<?php echo $this->cid; ?>, '<?php echo $musicArr[2]; ?>')" id="music-play-<?php echo $this->cid; ?>" class="music-play" />
                                    <img width="36" height="36" src="<?php $this->options->themeUrl('assets/svgs/music-pause-light.svg'); ?>" class="music-pause hidden" @click="pauseAudio(<?php echo $this->cid; ?>)" id="music-pause-<?php echo $this->cid; ?>" />
								</div>
							</div>
                        </figure>
                    </div>
                <?php
            }
        ?>

        <section class="grid grid-cols-3 gap-1 multi-pictures overflow-hidden mb-3 mt-3"
            id="preview-<?php echo $this->cid; ?>">
            <?php
            $friendVideo = $this->fields->friend_video;
            if (!empty($friendVideo)) {
                $autoplay = '';
                if ($this->options->autoPlayVideo == 'yes') {
                    $autoplay = 'autoplay';
                } else {
                    $autoplay = '';
                }
                $autoMuted = '';
                if ($this->options->autoMutedPlayVideo == 'yes') {
                    $autoMuted = 'muted';
                } else {
                    $autoMuted = '';
                }
                ?>
                <div class="overflow-hidden rounded-lg cursor-zoom-in w-full col-span-3">
                    <video src="<?php echo $friendVideo ?>" <?php echo $autoplay; ?>     <?php echo $autoMuted; ?> loop
                        preload="auto" controls="controls" class="w-full" data-cid="<?php echo $this->cid; ?>"
                        data-play="">您的浏览器不支持video标签</video>
                </div>
                <?php
            } else {
                $contentPictures = getAllImages($this->content);
                $friendPicture = $this->fields->friend_pictures;
                if ($friendPicture) {
                    $friendPictures = explode(',', $friendPicture);
                    foreach ($friendPictures as $friendPic) {
                        array_push($contentPictures, $friendPic);
                    }
                }
                $picture_list = array_filter(array_slice($contentPictures, 0, 9));
                if (count($picture_list) > 1) {
                    foreach ($picture_list as $picture) {
                        $exten = pathinfo($picture, PATHINFO_EXTENSION);
                        if ($exten)
                        ?>
                        <div class="overflow-hidden rounded-lg cursor-zoom-in w-full h-0 pt-[100%] relative">
                            <img src="<?php echo $picture ?>" data-fancybox="<?php echo $this->cid; ?>"
                                class="w-full h-full object-cover absolute top-0 cursor-zoom-in preview-image"
                                data-cid="<?php echo $this->cid; ?>" />
                        </div>
                        <?php
                    }
                } else if (count($picture_list) == 1) {
                    $exten = pathinfo($picture_list[0], PATHINFO_EXTENSION);
                    if ($exten)
                    ?>
                        <div class="overflow-hidden rounded-lg cursor-zoom-in w-full h-0 pt-[100%] relative col-span-3">
                            <img src="<?php echo $picture_list[0] ?>" data-fancybox="<?php echo $this->cid; ?>"
                                class="w-full h-full object-cover absolute top-0 cursor-zoom-in preview-image"
                                data-cid="<?php echo $this->cid; ?>" />
                        </div>
                    <?php
                }
                // }
            }
            ?>

        </section>
        <!--定位-->
        <section class="mb-2">
            <?php
            $position = $this->fields->position;
            if ($position) {
                ?>
                <span class="text-color-link text-xs cursor-default">
                    <?php echo $position ?>
                </span>
                <?php
            }
            ?>

        </section>
        <!--时间-->
        <section class="flex flex-row justify-between mb-3">
            <div class="text-gray text-xs">
                <?php echo getTimeFormatStr($this->created); ?>
            </div>
            <div class="w-[30px] h-[20px] relative">
                <div class="hudong dark:bg-[#262626] rounded-sm"></div>
                <div class="hudong-modal absolute right-10 top-[-10px] hidden animate-slideIn">
                    <div
                        class="bg-[#4c4c4c] text-[#fff] hudong-container pt-2 pb-2 pl-5 pr-5 flex flex-row items-center justify-between">

                        <?php
                        $isAgree = isAgreeByCid($this->cid);
                        ?>
                        <a href="javascript:;"
                            class="cursor-pointer text-[#fff] no-underline  items-center text-[14px] like-to <?php echo $isAgree ? 'flex' : 'hidden'; ?> like-to-cancel-<?php echo $this->cid; ?>"
                            data-cid="<?php echo $this->cid; ?>" data-agree="0"><span
                                class="hudong-liked inline-block mr-2 cursor-pointer"
                                data-cid="<?php echo $this->cid; ?>" data-agree="0"></span>取消</a>

                        <a href="javascript:;"
                            class="cursor-pointer text-[#fff] no-underline  items-center text-[14px] like-to <?php echo $isAgree ? 'hidden' : 'flex'; ?> like-to-show-<?php echo $this->cid; ?>"
                            data-cid="<?php echo $this->cid; ?>" data-agree="1"><span
                                class="hudong-like inline-block mr-2 cursor-pointer"
                                data-cid="<?php echo $this->cid; ?>" data-agree="1"></span>赞</a>

                        <span class="bg-[#454545] h-[22px] w-[1px]"></span>
                        <a href="javascript:;"
                            class="cursor-pointer text-[#fff] no-underline flex items-center text-[14px] comment-to"
                            data-cid="<?php echo $this->cid; ?>"><span
                                class="hudong-comment inline-block mr-2 cursor-pointer comment-to"
                                data-cid="<?php echo $this->cid; ?>"></span>评论</a>
                    </div>
                </div>
            </div>
        </section>
        <!--评论列表-->
        <section class="break-all">
            <?php $this->need('/components/option-like.php'); ?>
            <?php $this->need('/components/option-comment.php'); ?>
        </section>
    </div>
</article>