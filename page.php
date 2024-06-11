<?php
// 详情页
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>

<?php $this->need('/components/header.php'); ?>


<?php $this->need('/components/single-top.php'); ?>
<div class="bg-white dark:bg-[#323232] dark:text-[#cccccc] mx-auto main-container">

    <?php $this->need('/components/option-header.php'); ?>

    <div class="article-container">
        <article class="flex flex-row border-b borer-b-2 dark:border-gray-600 border-gray-200 p-5">
            <div class="mr-3">
                <div class="w-9 h-9">
                    <?php
                    $archiveUserAvatarUrl = $this->options->archiveUserAvatarUrl;
                    if (!empty($archiveUserAvatarUrl)) {
                        ?>
                        <img src="<?php echo $archiveUserAvatarUrl; ?>"
                            class="w-9 h-9 object-cover rounded-lg preview-image" />
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo $this->options->userAvatarUrl; ?>" class="w-9 h-9 object-cover rounded-lg" />
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div
                class="w-full border-t-0 border-l-0 border-r-0 border-b-1 dark:border-gray-600 border-gray-100 border-solid pb-1">
                <section class="flex flex-row justify-between items-center mb-1">
                    <span class="text-color-link cursor-default text-[14px]">
                        <?php //print_r(_getUserScreenNameByCid($item->cid)['screenName']); ?>
                    </span>
                </section>
                <section class="mb-1 cursor-default text-[14px] article-content break-all leading-6">
                    <?php
                    $this->content();
                    ?>
                </section>
            </div>
        </article>
    </div>
</div><!-- end #main-->

<?php $this->need('/components/modal.php'); ?>
<?php $this->need('/components/single-footer.php'); ?>