<?php
/**
 * 文章渲染
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
?>

<article class="flex flex-row border-b borer-b-2 dark:border-gray-800 border-gray-200 pt-5 pl-5 pr-5">
    <div class="mr-3">
        <div class="w-9 h-9">
            <?php
            // 作者，头像
            $authorId = $article->authorId;
            $archiveUserAvatarUrl = $this->options->archiveUserAvatarUrl;
            if (!empty($archiveUserAvatarUrl)) {
                ?>
                <img src="<?php echo $archiveUserAvatarUrl; ?>" class="w-9 h-9 object-cover rounded-lg preview-image"/>
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
        class="w-full border-t-0 border-l-0 border-r-0 border-b-1 dark:border-gray-800 border-gray-100 border-solid pb-1">
        <section class="flex flex-row justify-between items-center mb-1">
                <span class="text-color-link cursor-default text-[14px]">
                    <a href="<?php echo $article->permalink; ?>"
                       class="cursor-pointer text-color-link no-underline"><?php print_r(_getUserScreenNameByCid($article->cid)['screenName']); ?></a>
                <?php if ($isTop): ?>
                    <span class="text-[12px] p-1 text-red rounded-sm font-bold">置顶</span>
                <?php endif; ?>
                </span>
            <?php
            $advertiseData = getArticleFieldsByCid($article->cid, 'isAdvertise');
            if (count($advertiseData) > 0) {
                $isAdvertise = $advertiseData[0]['str_value'];
                if ($isAdvertise == true) {
                    ?>
                    <span class="text-[12px] dark:bg-[#262626] border-1 border-solid border-[#f0f0f0] px-1 text-[#c6c6c6] rounded-sm">广告</span>
                <?php }
            } ?>
        </section>
        <section
            class="mb-1 cursor-default text-[14px] article-content break-all <?php echo $lineClamp; ?> content-<?php echo $article->cid; ?>"
            data-cid="<?php echo $article->cid; ?>">
            <?php
            echo removeImgAndVideoTags($this::markdown($article->text));
            ?>
        </section>
        <?php
        if (!$isSingle) {
            ?>
            <div class="text-[14px] text-color-link cursor-pointer qw qw-<?php echo $article->cid; ?> hidden mb-1"
                 data-cid="<?php echo $article->cid; ?>">全文
            </div>
            <div class="text-[14px] text-color-link cursor-pointer ss ss-<?php echo $article->cid; ?> hidden mb-1"
                 data-cid="<?php echo $article->cid; ?>">收起
            </div>
            <?php
        }
        ?>
        <!--音乐卡片-->
        <?php include 'post-item-music.php'; ?>
        <!--视频-->
        <?php include 'post-item-video.php'; ?>
        <!--图片-->
        <?php include 'post-item-images.php'; ?>
        <!--定位-->
        <?php include 'post-item-position.php'; ?>
        <!--时间-->
        <?php include 'post-item-line-time.php'; ?>
        <!--评论列表-->
        <?php include 'post-item-comment.php'; ?>
    </div>
</article>