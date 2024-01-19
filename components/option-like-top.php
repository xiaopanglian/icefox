<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>

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