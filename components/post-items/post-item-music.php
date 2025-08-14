<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

$music = getArticleFieldsByCid($article->cid, 'music');
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
                     id="music-img-<?php echo $article->cid; ?>"/>
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
                         @click="playAudio(<?php echo $article->cid; ?>, '<?php echo $musicArr[2]; ?>', '<?php echo $musicArr[3]; ?>')"
                         id="music-play-<?php echo $article->cid; ?>" class="music-play"/>
                    <img width="36" height="36"
                         src="<?php $this->options->themeUrl('assets/svgs/music-pause-light.svg'); ?>"
                         class="music-pause hidden" @click="pauseAudio(<?php echo $article->cid; ?>)"
                         id="music-pause-<?php echo $article->cid; ?>"/>
                </div>
            </div>
        </figure>
    </section>
    <?php
}
?>