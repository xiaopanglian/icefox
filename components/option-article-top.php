<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

$topCids = explode(',', $this->options->topPost);
foreach ($topCids as $key => $value) {
    $topArticles = getArticleByCid($value);
    $topArticle = $topArticles[0];
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
                    <?php print_r($topArticle['screenName']); ?>
                    <span class="text-[12px] p-1 text-red rounded-sm">置顶</span>
                </span>
                <?php $isAdvertise = $this->fields->isAdvertise;
                if ($isAdvertise == true):
                    ?>
                    <span class="text-[12px] bg-[#f0f0f0] p-1 text-[#c6c6c6] rounded-sm">广告</span>
                <?php endif; ?>
            </section>
            <section
                class="cursor-default text-[14px] article-content break-all hidden-clamp content-<?php echo $topArticle['cid']; ?>"
                data-cid="<?php echo $topArticle['cid']; ?>">
                <?php echo $topArticle['text']; ?>
            </section>
            <span class="text-[14px] text-color-link cursor-pointer qw qw-<?php echo $topArticle['cid']; ?> hidden"
                data-cid="<?php echo $topArticle['cid']; ?>">全文</span>
            <span class="text-[14px] text-color-link cursor-pointer ss ss-<?php echo $topArticle['cid']; ?> hidden"
                data-cid="<?php echo $topArticle['cid']; ?>">收缩</span>
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
                $friendPicture = $this->fields->friend_pictures;
                if ($friendPicture) {
                    $friendPictures = explode(',', $friendPicture);
                    foreach ($friendPictures as $picture) {
                        ?>
                        <div class="overflow-hidden rounded-lg cursor-zoom-in w-full h-0 pt-[100%] relative">
                            <img src="<?php echo $picture ?>"
                                class="w-full h-full object-cover absolute top-0 cursor-zoom-in preview-image"
                                data-cid="<?php echo $topArticle['cid']; ?>" />
                        </div>
                        <?php
                    }
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
                    <?php echo getTimeFormatStr($topArticle['created']); ?>
                </div>
                <div class="w-[30px] h-[20px] relative">
                    <div class="hudong rounded-sm"></div>
                    <div class="hudong-modal absolute right-10 top-[-10px] hidden">
                        <div
                            class="bg-[#4c4c4c] text-[#fff] hudong-container pt-2 pb-2 pl-5 pr-5 flex flex-row items-center justify-between">
                            <a href="javascript:;"
                                class="cursor-pointer text-[#fff] no-underline flex items-center text-[14px]"><span
                                    class="hudong-like inline-block mr-2 cursor-pointer"></span>赞</a>
                            <span class="bg-[#454545] h-[22px] w-[1px]"></span>
                            <a href="javascript:;"
                                class="cursor-pointer text-[#fff] no-underline flex items-center text-[14px] comment-to"
                                data-cid="<?php echo $topArticle['cid']; ?>"><span
                                    class="hudong-comment inline-block mr-2 cursor-pointer"></span>评论</a>
                        </div>
                    </div>
                </div>
            </section>
            <!--评论列表-->
            <section>
                <?php $this->need('/components/option-like.php'); ?>
                <?php $this->need('/components/option-comment.php'); ?>
            </section>
        </div>
    </article>
    <?php
}
?>