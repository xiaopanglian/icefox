<template>
    <article class="flex flex-row border-b borer-b-2 border-gray-200 pt-5 pb-5">
        <div class="w-16 lg:w-32 flex justify-end pr-2 lg:pr-5">
            <img src="http://0ru.cn/usr/uploads/2023/08/523224250.png" alt=""
                class="w-[32px] h-[32px] lg:w-[64px] lg:h-[64px] rounded-lg object-cover" />
        </div>
        <div class="w-11/12 flex flex-col">
            <!--作者-->
            <div>
                <span class="text-[#576b95]">张三</span>
            </div>

            <!--内容-->
            <div class="mt-3 mb-3">
                <div class="text-[#1b1b1b] content">
                    当前发布版本：0.1.1
                    新增对文章的评论功能
                    新增对评论进行回复的功能
                    采用本地缓存的方式存储站点个人信息。
                </div>
            </div>

            <!--图片-->
            <div class="w-11/12">
                <div class="grid grid-cols-1">
                    <img src="http://0ru.cn/usr/uploads/2023/08/4281157489.jpg" alt=""
                        class="max-w-full max-h-48 object-cover cursor-pointer preview-image" />
                </div>


                <!-- <div class="jgg-container">

                    <div class="jgg-box">
                        <div class="content"><img src="' . $img . '" alt=""
                                class="w-full h-full object-cover cursor-pointer preview-image"></div>
                    </div>

                </div> -->
            </div>

            <!--时间-->
            <div class="flex flex-row justify-between mt-3 mr-5">

                <div class="font-light text-gray-500 text-sm">
                    <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished" class="">
                        1天前
                    </time>
                </div>
                <div class="relative">
                    <div class="bg-[#F7F7F7] flex justify-center rounded-sm cursor-pointer toggleCommentTip commentPoint">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full" viewBox="0 0 512 512"
                            width="20" height="20" class="ml-2 mr-2">
                            <g>
                                <circle r="50" cy="255" cx="355" fill="#576b95" />
                                <circle r="50" cy="255" cx="155" fill="#576b95" />
                            </g>
                        </svg>
                    </div>
                    <div
                        class="absolute right-16 top-[-10px] bg-[#4b5153] flex flex-row justify-center items-center rounded-lg commentTip hidden">
                        <div class="flex flex-row justify-center items-center pl-5 pr-5 pt-2 pb-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full" width="18" height="18"
                                viewBox="0 0 512 512">
                                <path
                                    d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z"
                                    fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="32" />
                            </svg>
                            <span class="text-white ml-1 mr-1">赞</span>
                        </div>
                        |
                        <div class="flex flex-row justify-center items-center ml-5 mr-5 cursor-pointer comment-btn"
                            data-respondId="<?php $this->respondId(); ?>" data-id="<?php $this->cid(); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full" width="18" height="18"
                                viewBox="0 0 512 512">
                                <path
                                    d="M408 64H104a56.16 56.16 0 00-56 56v192a56.16 56.16 0 0056 56h40v80l93.72-78.14a8 8 0 015.13-1.86H408a56.16 56.16 0 0056-56V120a56.16 56.16 0 00-56-56z"
                                    fill="none" stroke="#fff" stroke-linejoin="round" stroke-width="32" />
                            </svg>
                            <span class="text-white whitespace-nowrap ml-1 mr-1">评论</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--互动区-->
            <!-- <?php
                            $commentCount = articleCommentCount($this->cid);
                            ?> -->
            <div class="bg-[#F7F7F7] mr-5 mt-5 pt-2 pb-2 pl-4 pr-4">
                <!--                        <div class="flex flex-row items-center text-[#576b95] border-b border-[#F2F2F2] mb-2">-->
                <!--                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full"-->
                <!--                                 width="18" height="18" viewBox="0 0 512 512"-->
                <!--                            >-->
                <!--                                <path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="#576b95" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>-->
                <!--                            </svg>-->
                <!--                            <span class="ml-1">6位访客</span>-->
                <!--                        </div>-->
                <!-- <?php $this->need('components/comments.php'); ?> -->
                <div class="mt-3 comment-list-<?php $this->respondId(); ?>">
                    <!-- <?php articleComment($this->cid) ?> -->
                </div>
            </div>
    </div>
</article></template>