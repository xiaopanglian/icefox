<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>

<div class="index-comments bottom-shadow bg-[#f7f7f7] pl-3 pr-3 ">
    <ul class="list-none p-0 m-0 comment-ul-cid-<?php echo $this->cid; ?> comment-ul">
        <?php
        $comments = getCommentByCid($this->cid, 0, 999);
        if ($comments) {
            foreach ($comments as $comment): ?>
                <li class="pos-rlt comment-li-coid-<?php echo $comment['coid'] ?> pb-1">
                    <div class="comment-body">
                        <span class="text-[14px] text-color-link">
                            <a href="<?php echo $comment['url'] ?>" target="_blank"
                                class="cursor-pointer text-color-link no-underline">
                                <?php echo $comment['author']; ?>
                                <?php
                                if ($comment['authorId'] == $this->authorId) {
                                    ?>
                                    <span class="text-xs text-red-700 border border-red-700 border-solid pl-[1px] pr-[1px] rounded">作者</span>
                                    <?php
                                }
                                ?>
                            </a>
                        </span>
                        <span data-separator=":"
                            class="before:content-[attr(data-separator)] text-[14px] cursor-help comment-to"
                            data-coid="<?php echo $comment['coid'] ?>" data-cid="<?php echo $comment['cid'] ?>"
                            data-name="<?php echo $comment['author'] ?>">
                            <?php echo strip_tags(preg_replace("/<br>|<p>|<\/p>/", ' ', $comment['text'])) ?>
                        </span>
                    </div>
                </li>

                <?php
                $childComments = getCommentByCid($this->cid, $comment['coid'], 999);
                if ($childComments) {
                    foreach ($childComments as $childComment): ?>

                        <li class="pos-rlt comment-li-coid-<?php echo $childComment['coid'] ?>">
                            <div class="comment-body">
                                <span class="text-[14px] text-color-link">
                                    <a href="<?php echo $childComment['url'] ?>" target="_blank"
                                        class="cursor-pointer text-color-link no-underline">
                                        <?php echo $childComment['author'] ?>
                                        <?php
                                        if ($childComment['authorId'] == $this->authorId) {
                                            ?>
                                            <span class="text-xs text-red-700 border border-red-700 border-solid pl-[1px] pr-[1px] rounded">作者</span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </span>
                                <span class="text-[14px]">回复</span>
                                <span class="text-[14px] text-color-link">
                                    <?php echo $comment['author'] ?>
                                    <?php
                                    if ($comment['authorId'] == $this->authorId) {
                                        ?>
                                        <span class="text-xs text-red-700 border border-red-700 border-solid pl-[1px] pr-[1px] rounded">作者</span>
                                        <?php
                                    }
                                    ?>
                                </span>
                                <span data-separator=":"
                                    class="before:content-[attr(data-separator)] text-[14px] cursor-help comment-to"
                                    data-coid="<?php echo $childComment['coid'] ?>" data-cid="<?php echo $childComment['cid'] ?>"
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
        }
        ?>
    </ul>
</div>