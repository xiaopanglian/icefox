<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

$contentPictures = getAllImages($this::markdown($article->text));
$friendPicture = getArticleFieldsByCid($article->cid, 'friend_pictures');

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
        <section class="grid grid-cols-3 gap-1 multi-pictures overflow-hidden mb-3" id="preview-<?php echo $article->cid; ?>">
    <div class="overflow-hidden cursor-zoom-in col-span-2">
        <img data-src="<?php echo $picture_list[0] ?>" data-fancybox="<?php echo $article->cid; ?>"
             class="cursor-zoom-in preview-image max-w-full max-h-64"
             data-cid="<?php echo $article->cid; ?>"/>
    </div>
    </section>
    <?php

} else if (count($picture_list) == 4) {
    ?>
    <section class="grid grid-cols-3 gap-1 multi-pictures overflow-hidden mb-3"
             id="preview-<?php echo $article->cid; ?>">
        <div class="col-span-2 grid grid-cols-2 gap-1">
            <?php
            foreach ($picture_list as $picture) : ?>
                <div class="overflow-hidden cursor-zoom-in w-full h-0 pt-[100%] relative">
                    <img data-src="<?php echo $picture ?>" data-fancybox="<?php echo $article->cid; ?>"
                         class="w-full h-full object-cover absolute top-0 cursor-zoom-in preview-image"
                         data-cid="<?php echo $article->cid; ?>" alt=""/>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
} else if (count($picture_list) > 0) {
    ?>
    <section class="grid grid-cols-3 gap-1 multi-pictures overflow-hidden mb-3"
             id="preview-<?php echo $article->cid; ?>">
        <?php
        foreach ($picture_list as $picture) {
            $exten = pathinfo($picture, PATHINFO_EXTENSION);
            if ($exten)
                ?>
                <div class="overflow-hidden cursor-zoom-in w-full h-0 pt-[100%] relative">
                <img data-src="<?php echo $picture ?>" data-fancybox="<?php echo $article->cid; ?>"
                                                       class="w-full h-full object-cover absolute top-0 cursor-zoom-in preview-image"
                                                       data-cid="<?php echo $article->cid; ?>" />
            </div>
            <?php
        }
        ?>
    </section>
    <?php
}

?>