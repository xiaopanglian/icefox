<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
?>
<section class="break-all mb-1 overflow-hidden rounded-md">
    <?php

    $commentCount = 5;
    if ($this->is('single')) {
        $commentCount = 999;
    }

    $count = getCommentCountByCid($article->cid);
    $comments = getCommentByCid($article->cid, 0, $commentCount);
    $all = getChildCommentByCid($article->cid, 999);
    $dzClass = "";
    if ($count > 0) {
        $dzClass = "border-b-solid";
    }
    ?>
    <?php
    $agreeNum = getAgreeNumByCid($article->cid);
    $agree = $agreeNum['agree'];
    $recording = $agreeNum['recording'];
    ?>
    <div
        class="bg-[#f7f7f7] dark:bg-[#262626] px-3 py-2 bottom-shadow items-center border-1 <?php echo $dzClass; ?> dark:border-gray-800 border-gray-100 <?php echo($agree > 0 ? 'flex' : 'hidden'); ?> like-agree-<?php echo $article->cid; ?>">
        <span class="like inline-block mr-2"></span>
        <span class="text-[14px] ">
                        <span class="text-color-link text-[14px]">
                            <span class="fk-cid-<?php echo $article->cid; ?>">
                                <?php echo $agree; ?>
                            </span> 位访客
                        </span>
                    </span>
    </div>

    <div class="index-comments bottom-shadow bg-[#f7f7f7] dark:bg-[#262626] ">
        <ul class="list-none p-0 m-0 comment-ul-cid-<?php echo $article->cid; ?> comment-ul">
            <?php
            if ($comments) {
                foreach ($comments as $comment) : ?>
                    <li class="pos-rlt comment-li-coid-<?php echo $comment['coid'] ?> pb-1 px-2 first-of-type:pt-2">
                        <div class="comment-body">
                                        <span class="text-[14px] text-color-link">
                                            <a href="<?php echo $comment['url'] ?>" target="_blank"
                                               class="cursor-pointer text-color-link no-underline">
                                                <?php echo $comment['author']; ?>
                                                <?php
                                                if ($comment['authorId'] == $article->authorId) {
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
                                  data-coid="<?php echo $comment['coid'] ?>"
                                  data-cid="<?php echo $comment['cid'] ?>"
                                  data-name="<?php echo $comment['author'] ?>">
                                            <?php echo strip_tags(preg_replace("/<br>|<p>|<\/p>/", ' ', $comment['text'])) ?>
                                        </span>
                        </div>
                    </li>

                    <?php
                    $childComments = getChildCommentByCidOfComplete($comment['coid'], $all);
                    if ($childComments) {
                        foreach ($childComments as $childComment) : ?>

                            <li class="pos-rlt comment-li-coid-<?php echo $childComment['coid'] ?> pb-1 px-2">
                                <div class="comment-body">
                                                <span class="text-[14px] text-color-link">
                                                    <a href="<?php echo $childComment['url'] ?>" target="_blank"
                                                       class="cursor-pointer text-color-link no-underline">
                                                        <?php echo $childComment['author'] ?>
                                                        <?php
                                                        if ($childComment['authorId'] == $article->authorId) {
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
                                                    <?php echo $childComment['toAuthor'] ?>
                                        <?php
                                        if ($childComment['toAuthorId'] == $article->authorId) {
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
                    <li class="px-2 pb-1">
                        <a href="<?php echo $article->permalink; ?>"
                           class="cursor-pointer text-color-link no-underline text-[13px]">查看更多…</a>
                    </li>

                    <?php
                }
            }
            ?>
        </ul>
    </div>
</section>