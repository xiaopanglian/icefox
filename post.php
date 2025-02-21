<?php
// 详情页
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$isSingle = false;
$lineClamp = 'line-clamp-4';

if ($this->is('single')) {
    $isSingle = true;
    $lineClamp = '';
}
?>

<?php $this->need('/components/header.php'); ?>


<?php $this->need('/components/single-top.php'); ?>
    <div class="bg-white dark:bg-[#323232] dark:text-[#cccccc] mx-auto main-container">

        <?php $this->need('/components/option-header.php'); ?>

        <div class="article-container">
            <?php $this->widget('Widget_Archive@icefox' . $this->cid, 'pageSize=1&type=post', 'cid=' . $this->cid)->to($item); ?>
            <?php $item = (object)$item; ?>
            <article class="flex flex-row border-b borer-b-2 dark:border-gray-600 border-gray-200 pt-5 pl-5 pr-5">
                <div class="mr-3">
                    <div class="w-9 h-9">
                        <?php
                        $authorId = $item->authorId;
                        $archiveUserAvatarUrl = $this->options->archiveUserAvatarUrl;
                        if (!empty($archiveUserAvatarUrl)) {
                            ?>
                            <img src="<?php echo $archiveUserAvatarUrl; ?>"
                                 class="w-9 h-9 object-cover rounded-lg preview-image"/>
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo getUserAvatar($authorId); ?>"
                                 class="w-9 h-9 object-cover rounded-lg preview-image"/>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div
                    class="w-full border-t-0 border-l-0 border-r-0 border-b-1 dark:border-gray-600 border-gray-100 border-solid pb-1">
                    <section class="flex flex-row justify-between items-center mb-1">
                    <span class="text-color-link cursor-default text-[14px]">
                        <?php print_r(_getUserScreenNameByCid($item->cid)['screenName']); ?>
                    </span>
                        <?php
                        $advertiseData = getArticleFieldsByCid($item->cid, 'isAdvertise');
                        if (count($advertiseData) > 0) {
                            $isAdvertise = $advertiseData[0]['str_value'];
                            if ($isAdvertise == true) {
                                ?>
                                <span class="text-[12px] dark:bg-[#262626] bg-[#f0f0f0] p-1 text-[#c6c6c6] rounded-sm">广告</span>
                            <?php }
                        } ?>
                    </section>
                    <section
                        class="mb-1 cursor-default text-[14px] article-content break-all <?php echo $lineClamp; ?> content-<?php echo $item->cid; ?>"
                        data-cid="<?php echo $item->cid; ?>">
                        <?php
                        echo removeImgAndVideoTags($this::markdown($item->text));
                        ?>
                    </section>
                    <?php
                    if (!$isSingle) {
                        ?>
                        <div
                            class="text-[14px] text-color-link cursor-pointer qw qw-<?php echo $item->cid; ?> hidden mb-1"
                            data-cid="<?php echo $item->cid; ?>">全文
                        </div>
                        <div
                            class="text-[14px] text-color-link cursor-pointer ss ss-<?php echo $item->cid; ?> hidden mb-1"
                            data-cid="<?php echo $item->cid; ?>">收起
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    $music = getArticleFieldsByCid($item->cid, 'music');
                    if (count($music) > 0 && !empty($music[0]['str_value'])) {
                        $music = $music[0]['str_value'];
                        $musicArr = explode('||', $music);
                        ?>
                        <section class="w-full mb-1">
                            <figure class="flex overflow-hidden rounded-sm music-card m-0 bg-cover bg-center "
                                    style="background-color:#A2A3A1;">
                                <div
                                    class="w-full h-full bg-cover bg-center backdrop-blur-lg backdrop-filter bg-opacity-50 flex flex-row relative">
                                    <img src="<?php echo $musicArr[3]; ?>"
                                         class="h-full w-auto aspect-square object-cover music-img"
                                         id="music-img-<?php echo $item->cid; ?>"/>
                                    <div class="flex flex-col text-white h-full justify-center pl-[5px]">
                                    <span class="mt-1 truncate music-card-text">
                                        <?php echo $musicArr[0]; ?>
                                    </span>
                                        <span class="mt-1 truncate music-card-text">
                                        <?php echo $musicArr[1]; ?>
                                    </span>
                                    </div>
                                    <div class="music-card-play-position">
                                        <img width="36" height="36"
                                             src="<?php $this->options->themeUrl('assets/svgs/music-play-light.svg'); ?>"
                                             @click="playAudio(<?php echo $item->cid; ?>, '<?php echo $musicArr[2]; ?>', '<?php echo $musicArr[3]; ?>')"
                                             id="music-play-<?php echo $item->cid; ?>" class="music-play"/>
                                        <img width="36" height="36"
                                             src="<?php $this->options->themeUrl('assets/svgs/music-pause-light.svg'); ?>"
                                             class="music-pause hidden" @click="pauseAudio(<?php echo $item->cid; ?>)"
                                             id="music-pause-<?php echo $item->cid; ?>"/>
                                    </div>
                            </figure>
                        </section>
                        <?php
                    }
                    ?>

                    <?php
                    $friend_video = getArticleFieldsByCid($item->cid, 'friend_video');
                    if (count($friend_video) > 0 && !empty($friend_video[0]['str_value'])) {
                        $friendVideo = $friend_video[0]['str_value'];
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
                            <section class="grid grid-cols-12 gap-1 multi-pictures overflow-hidden mb-3"
                                     id="preview-<?php echo $item->cid; ?>">
                                <div class="overflow-hidden rounded-lg cursor-zoom-in w-full col-span-10">
                                    <video
                                        data-src="<?php echo $friendVideo ?>" <?php echo $autoplay; ?> <?php echo $autoMuted; ?>
                                        loop preload="auto"
                                        controls="controls" class="w-full js-player"
                                        data-cid="<?php echo $item->cid; ?>"
                                        data-play="" style="--plyr-color-main:#dcdfe5;"
                                        id="v-<?php echo $item->cid; ?>">您的浏览器不支持video标签
                                    </video>
                                </div>
                            </section>
                            <?php
                        }
                    } else {
                        $contentPictures = getAllImages($this::markdown($item->text));
                        $friendPicture = getArticleFieldsByCid($item->cid, 'friend_pictures');

                        if (count($friendPicture) > 0) {
                            foreach ($friendPicture as $tmpFriendPic) {
                                $onePic = $tmpFriendPic['str_value'];

                                $friendPictures = explode(',', $onePic);
                                foreach ($friendPictures as $friendPic) {
                                    array_push($contentPictures, $friendPic);
                                }
                            }
                        }

                        $picture_list = array_filter(array_slice($contentPictures, 0, 9));

                        if (count($picture_list) == 1) {
                            $exten = pathinfo($picture_list[0], PATHINFO_EXTENSION);
                            if ($exten)
                                ?>
                                <section class="grid grid-cols-3 gap-1 multi-pictures overflow-hidden mb-3"
                                id="preview-<?php echo $item->cid; ?>">
                            <div class="overflow-hidden cursor-zoom-in col-span-2">
                                <img data-src="<?php echo $picture_list[0] ?>" data-fancybox="<?php echo $item->cid; ?>"
                                     class="cursor-zoom-in preview-image max-w-full max-h-64"
                                     data-cid="<?php echo $item->cid; ?>"/>
                            </div>
                            </section>
                            <?php

                        } else if (count($picture_list) == 4) {
                            ?>
                            <section class="grid grid-cols-3 gap-1 multi-pictures overflow-hidden mb-3"
                                     id="preview-<?php echo $item->cid; ?>">
                                <div class="col-span-2 grid grid-cols-2 gap-1">
                                    <?php
                                    foreach ($picture_list as $picture): ?>
                                        <div class="overflow-hidden cursor-zoom-in w-full h-0 pt-[100%] relative">
                                            <img data-src="<?php echo $picture ?>"
                                                 data-fancybox="<?php echo $item->cid; ?>"
                                                 class="w-full h-full object-cover absolute top-0 cursor-zoom-in preview-image"
                                                 data-cid="<?php echo $item->cid; ?>" alt=""/>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                            <?php
                        } else if (count($picture_list) > 0) {
                            ?>
                            <section class="grid grid-cols-3 gap-1 multi-pictures overflow-hidden mb-3"
                                     id="preview-<?php echo $item->cid; ?>">
                                <?php
                                foreach ($picture_list as $picture) {
                                    $exten = pathinfo($picture, PATHINFO_EXTENSION);
                                    if ($exten)
                                        ?>
                                        <div class="overflow-hidden cursor-zoom-in w-full h-0 pt-[100%] relative">
                                        <img data-src="<?php echo $picture ?>" data-fancybox="<?php echo $item->cid; ?>"
                                                                               class="w-full h-full object-cover absolute top-0 cursor-zoom-in preview-image"
                                                                               data-cid="<?php echo $item->cid; ?>" />
                                    </div>
                                    <?php
                                }
                                ?>
                            </section>
                            <?php
                        }


                    }
                    ?>

                    <!--定位-->
                    <section class="mb-1">
                        <?php
                        $position = getArticleFieldsByCid($item->cid, 'position');
                        if (count($position) > 0) {
                            ?>
                            <span class="text-color-link text-xs cursor-default">
                            <?php echo $position[0]['str_value'] ?>
                        </span>
                            <?php
                        }
                        ?>

                    </section>
                    <!--时间-->
                    <section class="flex flex-row justify-between mb-1">
                        <div class="text-gray text-xs">
                            <?php echo getTimeFormatStr($item->created); ?>
                        </div>
                        <div class="w-[30px] h-[20px] relative">
                            <div class="hudong dark:bg-[#262626] rounded-sm"></div>
                            <div class="hudong-modal animate-slide-in absolute right-10 top-[-10px] hidden">
                                <div
                                    class="bg-[#4c4c4c] text-[#fff] hudong-container pt-2 pb-2 pl-5 pr-5 flex flex-row items-center justify-between">

                                    <?php
                                    $isAgree = isAgreeByCid($item->cid);
                                    ?>
                                    <a href="javascript:;"
                                       class="cursor-pointer text-[#fff] no-underline  items-center text-[14px] like-to <?php echo $isAgree ? 'flex' : 'hidden'; ?> like-to-cancel-<?php echo $item->cid; ?>"
                                       data-cid="<?php echo $item->cid; ?>" data-agree="0"><span
                                            class="hudong-liked inline-block mr-2 cursor-pointer"
                                            data-cid="<?php echo $item->cid; ?>" data-agree="0"></span>取消</a>

                                    <a href="javascript:;"
                                       class="cursor-pointer text-[#fff] no-underline  items-center text-[14px] like-to <?php echo $isAgree ? 'hidden' : 'flex'; ?> like-to-show-<?php echo $item->cid; ?>"
                                       data-cid="<?php echo $item->cid; ?>" data-agree="1"><span
                                            class="hudong-like inline-block mr-2 cursor-pointer"
                                            data-cid="<?php echo $item->cid; ?>" data-agree="1"></span>赞</a>

                                    <span class="bg-[#454545] h-[22px] w-[1px]"></span>
                                    <a href="javascript:;"
                                       class="cursor-pointer text-[#fff] no-underline flex items-center text-[14px] comment-to"
                                       data-cid="<?php echo $item->cid; ?>"><span
                                            class="hudong-comment inline-block mr-2 cursor-pointer comment-to"
                                            data-cid="<?php echo $item->cid; ?>"></span>评论</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--评论列表-->
                    <section class="break-all mb-1 overflow-hidden rounded-md">
                        <?php

                        $commentCount = 5;
                        if ($this->is('single')) {
                            $commentCount = 999;
                        }

                        $count = getCommentCountByCid($item->cid);
                        $comments = getCommentByCid($item->cid, 0, $commentCount);
                        $all = getChildCommentByCid($item->cid, 999);
                        $dzClass = "";
                        if ($count > 0) {
                            $dzClass = "border-b-solid";
                        }
                        ?>
                        <?php
                        $agreeNum = getAgreeNumByCid($item->cid);
                        $agree = $agreeNum['agree'];
                        $recording = $agreeNum['recording'];
                        ?>
                        <div
                            class="bg-[#f7f7f7] dark:bg-[#262626] px-3 py-2 bottom-shadow items-center border-1 <?php echo $dzClass; ?> dark:border-gray-600 border-gray-100 <?php echo($agree > 0 ? 'flex' : 'hidden'); ?> like-agree-<?php echo $item->cid; ?>">
                            <span class="like inline-block mr-2"></span>
                            <span class="text-[14px] ">
                            <span class="text-color-link text-[14px]">
                                <span class="fk-cid-<?php echo $item->cid; ?>">
                                    <?php echo $agree; ?>
                                </span> 位访客
                            </span>
                        </span>
                        </div>

                        <div class="index-comments bottom-shadow bg-[#f7f7f7] dark:bg-[#262626] ">
                            <ul class="list-none p-0 m-0 comment-ul-cid-<?php echo $item->cid; ?> comment-ul">
                                <?php
                                if ($comments) {
                                    foreach ($comments as $comment): ?>
                                        <li
                                            class="pos-rlt comment-li-coid-<?php echo $comment['coid'] ?> pb-1 px-2 first-of-type:pt-2">
                                            <div class="comment-body">
                                            <span class="text-[14px] text-color-link">
                                                <a href="<?php echo $comment['url'] ?>" target="_blank"
                                                   class="cursor-pointer text-color-link no-underline">
                                                    <?php echo $comment['author']; ?>
                                                    <?php
                                                    if ($comment['authorId'] == $item->authorId) {
                                                        ?>
                                                        <span
                                                            class="text-xs text-red-700 border border-red-700 border-solid pl-[1px] pr-[1px] rounded">作者</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </a>
                                            </span>
                                                <span data-separator=":"
                                                      class="before:content-[attr(data-separator)] text-[14px] cursor-help comment-to"
                                                      data-coid="<?php echo $comment['coid'] ?>"
                                                      data-cid="<?php echo $comment['cid'] ?>"
                                                      data-name="<?php echo $comment['author'] ?>">
                                                <?php echo strip_tags(preg_replace("/<br>|<p>|<\/p>/", ' ', $comment['text'])) ?>
                                            </span>
                                            </div>
                                        </li>

                                        <?php
                                        $childComments = getChildCommentByCidOfComplete($comment['coid'], $all);
                                        if ($childComments) {
                                            foreach ($childComments as $childComment): ?>

                                                <li class="pos-rlt comment-li-coid-<?php echo $childComment['coid'] ?> pb-1 px-2">
                                                    <div class="comment-body">
                                                    <span class="text-[14px] text-color-link">
                                                        <a href="<?php echo $childComment['url'] ?>" target="_blank"
                                                           class="cursor-pointer text-color-link no-underline">
                                                            <?php echo $childComment['author'] ?>
                                                            <?php
                                                            if ($childComment['authorId'] == $item->authorId) {
                                                                ?>
                                                                <span
                                                                    class="text-xs text-red-700 border border-red-700 border-solid pl-[1px] pr-[1px] rounded">作者</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </a>
                                                    </span>
                                                        <span class="text-[14px]">回复</span>
                                                        <span class="text-[14px] text-color-link">
                                                        <?php echo $childComment['toAuthor'] ?>
                                                            <?php
                                                            if ($childComment['toAuthorId'] == $item->authorId) {
                                                                ?>
                                                                <span
                                                                    class="text-xs text-red-700 border border-red-700 border-solid pl-[1px] pr-[1px] rounded">作者</span>
                                                                <?php
                                                            }
                                                            ?>
                                                    </span>
                                                        <span data-separator=":"
                                                              class="before:content-[attr(data-separator)] text-[14px] cursor-help comment-to"
                                                              data-coid="<?php echo $childComment['coid'] ?>"
                                                              data-cid="<?php echo $childComment['cid'] ?>"
                                                              data-name="<?php echo $childComment['author'] ?>">
                                                        <?php echo strip_tags(preg_replace("/<br>|<p>|<\/p>/", ' ', $childComment['text'])) ?>
                                                    </span>

                                                    </div>
                                                </li>
                                            <?php endforeach;
                                        }
                                        ?>

                                        <?php ?>
                                    <?php endforeach; ?>
                                    <?php
                                    if ($count > 5 & $commentCount == 5) {
                                        ?>
                                        <li class="px-2 pb-1">
                                            <a href="<?php echo $item->permalink; ?>"
                                               class="cursor-pointer text-color-link no-underline text-[13px]">查看更多…</a>
                                        </li>

                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </section>
                </div>
            </article>
        </div>
    </div><!-- end #main-->

<?php $this->need('/components/modal.php'); ?>
<?php $this->need('/components/single-footer.php'); ?>