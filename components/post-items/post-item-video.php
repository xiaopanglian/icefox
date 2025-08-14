<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

$friend_video = getArticleFieldsByCid($article->cid, 'friend_video');
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
                 id="preview-<?php echo $article->cid; ?>">
            <div class="overflow-hidden rounded-lg cursor-zoom-in w-full col-span-10">
                <video data-src="<?php echo $friendVideo ?>" <?php echo $autoplay; ?> <?php echo $autoMuted; ?>
                       loop preload="auto" controls="controls" class="w-full js-player"
                       data-cid="<?php echo $article->cid; ?>" data-play="" style="--plyr-color-main:#dcdfe5;"
                       id="v-<?php echo $article->cid; ?>">您的浏览器不支持video标签
                </video>
            </div>
        </section>
        <?php
    }
}
?>