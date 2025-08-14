<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
?>
<section class="flex flex-row justify-between mb-1">
            <div class="text-gray text-xs">
                <?php echo getTimeFormatStr($article->created); ?>
            </div>
            <div class="w-[30px] h-[20px] relative">
                <div class="hudong dark:bg-[#262626] rounded-sm"></div>
                <div class="hudong-modal animate-slide-in absolute right-10 top-[-10px] hidden">
                    <div
                        class="bg-[#4c4c4c] text-[#fff] hudong-container pt-2 pb-2 pl-5 pr-5 flex flex-row items-center justify-between">

                        <?php
                        $isAgree = isAgreeByCid($article->cid);
                        ?>
                        <a href="javascript:;"
                           class="cursor-pointer text-[#fff] no-underline  items-center text-[14px] like-to <?php echo $isAgree ? 'flex' : 'hidden'; ?> like-to-cancel-<?php echo $article->cid; ?>"
                           data-cid="<?php echo $article->cid; ?>" data-agree="0"><span
                                class="hudong-liked inline-block mr-2 cursor-pointer"
                                data-cid="<?php echo $article->cid; ?>" data-agree="0"></span>取消</a>

                        <a href="javascript:;"
                           class="cursor-pointer text-[#fff] no-underline  items-center text-[14px] like-to <?php echo $isAgree ? 'hidden' : 'flex'; ?> like-to-show-<?php echo $article->cid; ?>"
                           data-cid="<?php echo $article->cid; ?>" data-agree="1"><span
                                class="hudong-like inline-block mr-2 cursor-pointer"
                                data-cid="<?php echo $article->cid; ?>" data-agree="1"></span>赞</a>

                        <span class="bg-[#454545] h-[22px] w-[1px]"></span>
                        <a href="javascript:;"
                           class="cursor-pointer text-[#fff] no-underline flex items-center text-[14px] comment-to"
                           data-cid="<?php echo $article->cid; ?>"><span
                                class="hudong-comment inline-block mr-2 cursor-pointer comment-to"
                                data-cid="<?php echo $article->cid; ?>"></span>评论</a>
                    </div>
                </div>
            </div>
        </section>