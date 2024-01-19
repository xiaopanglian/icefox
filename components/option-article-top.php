<?php
/**
 * 置顶文章列表
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$isSingle = false;
$lineClamp = 'line-clamp-4';

if ($this->is('single')) {
    $isSingle = true;
    $lineClamp = '';
}
$topCids = explode(',', $this->options->topPost);
foreach ($topCids as $key => $value) {
    $topArticles = getArticleByCid($value);
    if (count($topArticles) == 0) {
        continue;
    }
    $topArticle = $topArticles[0];
    if ($topArticle == null) {
        continue;
    }
    // print_r($topArticle);
    ?>

    <article class="flex flex-row border-b borer-b-2 border-gray-200 pt-5 pl-5 pr-5">
        <div class="mr-3">
            <div class="w-9 h-9">
                <img src="<?php echo $this->options->userAvatarUrl ?>" class="w-9 h-9 object-cover rounded-lg" />
            </div>
        </div>
        <div class="w-full border-t-0 border-l-0 border-r-0 border-b-1 border-gray-100 border-solid">
            <section class="flex flex-row justify-between items-center">
                <span class="text-color-link cursor-default text-[14px]">
                    <?php echo $topArticle['screenName']; ?>
                    <span class="text-[12px] p-1 text-red rounded-sm">置顶</span>
                </span>
                <?php
                $advertiseData = getArticleFieldsByCid($topArticle['cid'], 'isAdvertise');
                if (count($advertiseData) > 0) {
                    $isAdvertise = $advertiseData[0]['str_value'];
                    if ($isAdvertise == true) {
                        ?>
                        <span class="text-[12px] bg-[#f0f0f0] p-1 text-[#c6c6c6] rounded-sm">广告</span>
                    <?php }
                } ?>
            </section>
            <section
                class="cursor-default text-[14px] article-content break-all <?php echo $lineClamp; ?> content-<?php echo $topArticle['cid']; ?>"
                data-cid="<?php echo $topArticle['cid']; ?>">
                <?php echo $topArticle['text']; ?>
            </section>
            <?php
            if (!$isSingle) {
                ?>
                <div class="text-[14px] text-color-link cursor-pointer qw qw-<?php echo $topArticle['cid']; ?> hidden"
                    data-cid="<?php echo $topArticle['cid']; ?>">全文</div>
                <div class="text-[14px] text-color-link cursor-pointer ss ss-<?php echo $topArticle['cid']; ?> hidden"
                    data-cid="<?php echo $topArticle['cid']; ?>">收缩</div>
                <?php
            }
            ?>
            <!--一张图-->
            <!-- <div>
                    <div>
                        <img src="http://localhost:8008/usr/uploads/2023/11/3995299155.jpg" class="max-h-[300] max-w-[300] object-cover" />
                    </div>
                </div> -->
            <!--多图-->

            <section class="grid grid-cols-3 gap-1 multi-pictures overflow-hidden mb-3 mt-3"
                id="preview-<?php echo $topArticle['cid']; ?>">
                <?php
                $friend_video = getArticleFieldsByCid($topArticle['cid'], 'friend_video');
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
                        <div class="overflow-hidden rounded-lg cursor-zoom-in w-full col-span-3">
                            <video src="<?php echo $friendVideo ?>" <?php echo $autoplay; ?>             <?php echo $autoMuted; ?> loop
                                preload="auto" controls="controls" class="w-full" data-cid="<?php echo $topArticle['cid']; ?>"
                                data-play="">您的浏览器不支持video标签</video>
                        </div>
                        <?php
                    }
                } else {

                    $friend_pictures = getArticleFieldsByCid($topArticle['cid'], 'friend_pictures');
                    // print_r($friend_pictures);
                    if (count($friend_pictures) > 0) {
                        $friendPicture = $friend_pictures[0]['str_value'];
                        if ($friendPicture) {
                            $friendPictures = explode(',', $friendPicture);
                            foreach ($friendPictures as $picture) {
                                $exten = pathinfo($friendPicture, PATHINFO_EXTENSION);
                                if ($exten)
                                ?>
                                <div class="overflow-hidden rounded-lg cursor-zoom-in w-full h-0 pt-[100%] relative">
                                    <img src="<?php echo $picture ?>"
                                        class="w-full h-full object-cover absolute top-0 cursor-zoom-in preview-image"
                                        data-cid="<?php echo $topArticle['cid']; ?>" />
                                </div>
                                <?php
                            }
                        }
                    }

                }
                ?>

            </section>
            <!--定位-->
            <section class="mb-2">
                <?php
                $position = getArticleFieldsByCid($topArticle['cid'], 'position');
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
            <section class="flex flex-row justify-between mb-3">
                <div class="text-gray text-xs">
                    <?php echo getTimeFormatStr($topArticle['created']); ?>
                </div>
                <div class="w-[30px] h-[20px] relative">
                    <div class="hudong rounded-sm"></div>
                    <div class="hudong-modal absolute right-10 top-[-10px] hidden">
                        <div
                            class="bg-[#4c4c4c] text-[#fff] hudong-container pt-2 pb-2 pl-5 pr-5 flex flex-row items-center justify-between">

                            <?php
                            $isAgree = isAgreeByCid($topArticle['cid']);
                            ?>
                            <a href="javascript:;"
                                class="cursor-pointer text-[#fff] no-underline  items-center text-[14px] like-to <?php echo $isAgree ? 'flex' : 'hidden'; ?> like-to-cancel-<?php echo $topArticle['cid']; ?>"
                                data-cid="<?php echo $topArticle['cid']; ?>" data-agree="0"><span
                                    class="hudong-liked inline-block mr-2 cursor-pointer"
                                    data-cid="<?php echo $topArticle['cid']; ?>" data-agree="0"></span>取消</a>

                            <a href="javascript:;"
                                class="cursor-pointer text-[#fff] no-underline  items-center text-[14px] like-to <?php echo $isAgree ? 'hidden' : 'flex'; ?> like-to-show-<?php echo $topArticle['cid']; ?>"
                                data-cid="<?php echo $topArticle['cid']; ?>" data-agree="1"><span
                                    class="hudong-like inline-block mr-2 cursor-pointer"
                                    data-cid="<?php echo $topArticle['cid']; ?>" data-agree="1"></span>赞</a>

                            <span class="bg-[#454545] h-[22px] w-[1px]"></span>
                            <a href="javascript:;"
                                class="cursor-pointer text-[#fff] no-underline flex items-center text-[14px] comment-to"
                                data-cid="<?php echo $topArticle['cid']; ?>"><span
                                    class="hudong-comment inline-block mr-2 cursor-pointer comment-to"
                                    data-cid="<?php echo $topArticle['cid']; ?>"></span>评论</a>
                        </div>
                    </div>
                </div>
            </section>
            <!--评论列表-->
            <section class="break-all">
                <?php
                $agreeNum = getAgreeNumByCid($topArticle['cid']);
                $agree = $agreeNum['agree'];
                $recording = $agreeNum['recording'];
                ?>
                <div
                    class="bg-[#f7f7f7] pt-1 pb-1 pl-3 pr-3 bottom-shadow items-center border-1 border-b-solid border-gray-100 <?php echo ($agree > 0 ? 'flex' : 'hidden'); ?> like-agree-<?php echo $topArticle['cid']; ?>">
                    <span class="like inline-block mr-2"></span>
                    <span class="text-[14px] ">
                        <!-- <span class="text-color-link no-underline text-[14px]">刘德华</span>,
            <span class="text-color-link no-underline text-[14px]">张学友</span>, -->
                        <span class="text-color-link text-[14px]">
                            <span class="fk-cid-<?php echo $topArticle['cid']; ?>">
                                <?php echo $agree; ?>
                            </span> 位访客
                        </span>
                    </span>
                </div>


                <?php

                $commentCount = 5;
                if ($this->is('single')) {
                    $commentCount = 999;
                }
                ?>

                <div class="index-comments bottom-shadow bg-[#f7f7f7] pl-3 pr-3 ">
                    <ul class="list-none p-0 m-0 comment-ul-cid-<?php echo $topArticle['cid']; ?> comment-ul">
                        <?php
                        $count = getCommentCountByCid($topArticle['cid']);
                        $comments = getCommentByCid($topArticle['cid'], 0, $commentCount);
                        if ($comments) {
                            foreach ($comments as $comment): ?>
                                <li class="pos-rlt comment-li-coid-<?php echo $comment['coid'] ?> pb-1">
                                    <div class="comment-body">
                                        <span class="text-[14px] text-color-link">
                                            <a href="<?php echo $comment['url'] ?>" target="_blank"
                                                class="cursor-pointer text-color-link no-underline">
                                                <?php echo $comment['author']; ?>
                                                <?php
                                                if ($comment['authorId'] == $topArticle['authorId']) {
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
                                            data-coid="<?php echo $comment['coid'] ?>" data-cid="<?php echo $comment['cid'] ?>"
                                            data-name="<?php echo $comment['author'] ?>">
                                            <?php echo strip_tags(preg_replace("/<br>|<p>|<\/p>/", ' ', $comment['text'])) ?>
                                        </span>
                                    </div>
                                </li>

                                <?php
                                $childComments = getCommentByCid($topArticle['cid'], $comment['coid'], 999);
                                if ($childComments) {
                                    foreach ($childComments as $childComment): ?>

                                        <li class="pos-rlt comment-li-coid-<?php echo $childComment['coid'] ?>">
                                            <div class="comment-body">
                                                <span class="text-[14px] text-color-link">
                                                    <a href="<?php echo $childComment['url'] ?>" target="_blank"
                                                        class="cursor-pointer text-color-link no-underline">
                                                        <?php echo $childComment['author'] ?>
                                                        <?php
                                                        if ($childComment['authorId'] == $topArticle['authorId']) {
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
                                                    <?php echo $comment['author'] ?>
                                                    <?php
                                                    if ($comment['authorId'] == $topArticle['authorId']) {
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
                                <li>
                                    <a href="<?php $this->permalink() ?>"
                                        class="cursor-pointer text-color-link no-underline text-[14px]">查看更多...</a>
                                </li>

                                <?php
                            }
                            ?>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </section>
        </div>
    </article>
    <?php
}
?>