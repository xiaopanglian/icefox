<template>
  <article class="flex flex-row border-b borer-b-2 border-gray-200 pt-5 pb-5">
    <div class="w-16 lg:w-32 flex justify-end pr-2 lg:pr-5">
      <img src="http://0ru.cn/usr/uploads/2023/08/523224250.png" alt=""
           class="w-[32px] h-[32px] lg:w-[64px] lg:h-[64px] rounded-lg object-cover"/>
    </div>
    <div class="w-11/12 flex flex-col">
      <!--作者-->
      <div>
        <span class="text-[#576b95]">小胖脸</span>
      </div>

      <!--内容-->
      <div class="mt-3 mb-3">
        <div class="text-[#1b1b1b] content">
          <span v-html="text"></span>
        </div>
      </div>

      <!--图片-->
      <div class="w-11/12">
        <div class="grid grid-cols-1" v-if="imgs.length === 1">
          <el-image :src="url" alt="" class="max-w-full max-h-48 object-cover cursor-pointer preview-image"
                    :zoom-rate="1.2" :preview-src-list="imgs" :initial-index="4" fit="cover" :hide-on-click-modal="true"/>
        </div>


        <div class="jgg-container" v-if="imgs.length > 1">

          <div class="jgg-box" v-for="src in imgs">
            <div class="content">
              <el-image :src="src" alt="" class="w-full h-full object-cover cursor-pointer preview-image"
                        :zoom-rate="1.2" :preview-src-list="imgs" :initial-index="4" fit="cover" :hide-on-click-modal="true"/>
            </div>
          </div>

        </div>
      </div>

      <!--时间-->
      <div class="flex flex-row justify-between mt-3 mr-5">

        <div class="font-light text-gray-500 text-sm">
          <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished" class="">
            1天前
          </time>
        </div>
        <div class="relative">
          <div class="bg-[#F7F7F7] flex justify-center rounded-sm cursor-pointer toggleCommentTip commentPoint" @click="showCommentTip">
            <IconCommentMore></IconCommentMore>
          </div>
          <div
              class="absolute right-16 top-[-10px] bg-[#4b5153] flex flex-row justify-center items-center rounded-lg commentTip" v-if="showCommentTipField">
            <div class="flex flex-row justify-center items-center pl-5 pr-5 pt-2 pb-2 cursor-pointer">
              <IconNice></IconNice>
              <span class="text-white ml-1 mr-1">赞</span>
            </div>
            |
            <div class="flex flex-row justify-center items-center ml-5 mr-5 cursor-pointer comment-btn"
                 data-respondId="" data-id="">
              <IconComment></IconComment>
              <span class="text-white whitespace-nowrap ml-1 mr-1" @click="showCommentForm">评论</span>
            </div>
          </div>
        </div>
      </div>

      <!--互动区-->
      <!-- <?php
                      $commentCount = articleCommentCount($this->cid);
                      ?> -->
      <div class="bg-[#F7F7F7] mr-5 mt-5 pt-2 pb-2 pl-4 pr-4" v-if="showCommentContainer">
        <div class="mt-3 ">
          <div class="border border-[#07c160] rounded-lg p-2 bg-white" v-if="showCommentFormField">
            <div data-action="" class="">
              <label>
                <input class="w-full h-full rounded-lg outline-none resize-none " placeholder="评论" name="text"/>
              </label>

              <input type="hidden" name="_" value="" class="_<?php $this->respondId(); ?>"/>
              <input type="hidden" name="cid" value="" class=""/>
              <div class="flex justify-between items-start">
                <div class="flex flex-col bg-[#F7F7F7] gap-1 p-1 ">
                  <label><input placeholder="*昵称" class="border outline-none "/></label>
                  <label><input placeholder="*邮箱" class="border outline-none "/></label>
                  <label><input placeholder="*网址" class="border outline-none "/></label>
                </div>
                <div class="exists-<?php $this->respondId(); ?>">
                  <span class="text-gray-400 text-sm "></span>
                  <span class="cursor-pointer text-gray-400 text-sm comment-edit" data-respondId="">[编辑]</span>
                </div>
                <div class="flex flex-row items-center justify-end">
                <span>
                    <IconSmiley></IconSmiley>
                </span>
                  <button class="bg-[#07c160] text-white pl-3 pr-3 pt-1 pb-1 ml-2 rounded-sm comment-submit" type="button" data-id="">提交</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>
</template>

<script setup>
import {ref} from "vue";
import IconCommentMore from "@/components/icons/IconCommentMore.vue";
import IconNice from "@/components/icons/IconNice.vue";
import IconComment from "@/components/icons/IconComment.vue";
import IconSmiley from "@/components/icons/IconSmiley.vue";

const props = defineProps(['data']);

const imgs = ref([]);
if (props.data.fields.friend_pictures) {
  imgs.value = props.data.fields.friend_pictures.value.split(',');
}

let url = ref('')
if (imgs.value.length > 0) {
  url = imgs.value[0]
}

// 文章内容。正则过滤html标签
const text = props.data.text.replaceAll('<br>', '\r\n').replace(/<\/?.+?\/?>/g, '').replaceAll('\r\n', '<br>')

const showCommentTipField = ref(false);

/**
 * 显示隐藏评论更多提示菜单
 */
function showCommentTip() {
  showCommentTipField.value = !showCommentTipField.value;
}

/**
 * 显示隐藏评论表单
 * @type {Ref<UnwrapRef<boolean>>}
 */
const showCommentFormField = ref(false)

function showCommentForm() {
  showCommentFormField.value = !showCommentFormField.value;
  ShowCommentContainer();
}

const showCommentContainer = ref(false)

function ShowCommentContainer() {
  if (showCommentFormField.value === true) {
    showCommentContainer.value = true;
  } else {
    showCommentContainer.value = false;
  }
}
</script>