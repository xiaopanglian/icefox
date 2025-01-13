<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
?>
<section class="mb-1">
    <?php
    $position = getArticleFieldsByCid($article->cid, 'position');
    $positionUrl = getArticleFieldsByCid($article->cid, 'positionUrl');
    if (!empty($position)) {
        if (count($positionUrl) > 0) {
            $strValue = $positionUrl[0]['str_value'];
            if (!empty($strValue)) {
                ?>
                <a href="<?php echo $strValue; ?>" class=" text-color-link text-xs cursor-pointer no-underline">
                    <img src="<?php $this->options->themeUrl('assets/svgs/position-link.svg'); ?>"
                         class="w-[10px] h-[10px] text-color-link"/>
                    <?php echo $position[0]['str_value'] ?>
                </a>
                <?php
            } else {
                ?>
                <span class="text-color-link text-xs cursor-default">
                    <?php echo $position[0]['str_value'] ?>
                </span>
                <?php
            }
        } else {
            ?>
            <span class="text-color-link text-xs cursor-default">
                <?php echo $position[0]['str_value'] ?>
            </span>
            <?php
        }
    }
    ?>

</section>