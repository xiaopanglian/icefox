<template>
  <article class="flex flex-row border-b borer-b-2 border-gray-200 pt-5 pb-5">
    <div class="w-16 lg:w-32 flex justify-end pr-2 lg:pr-5">
      <img :src="avatarUrl" alt="头像avatarUrl"
           class="w-[32px] h-[32px] lg:w-[64px] lg:h-[64px] rounded-lg object-cover"/>
    </div>
    <div class="w-11/12 flex flex-col">
      <!--作者-->
      <div>
        <span class="text-[#576b95]">{{ nickName }}</span>
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
          <span itemprop="datePublished" class="">
            {{ time.getFormatTime(props.data.created) }}
          </span>
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
              <span class="text-white whitespace-nowrap ml-1 mr-1" @click="showCommentForm(0, '')">评论</span>
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
                <input class="w-full h-full rounded-lg outline-none resize-none " :placeholder="formPlaceHolder" name="text" v-model="content"/>
              </label>

              <div class="flex justify-between items-start">
                <div class="flex flex-col bg-[#F7F7F7] gap-1 p-1 " v-if="isShowUserInfoForm">
                  <label><input placeholder="*昵称" class="border outline-none " v-model="nickname"/></label>
                  <label><input placeholder="*邮箱" class="border outline-none " v-model="mail"/></label>
                  <label><input placeholder="*网址" class="border outline-none " v-model="userAddress"/></label>
                </div>
                <div class="exists-<?php $this->respondId(); ?>" v-if="!isShowUserInfoForm">
                  <span class="text-gray-400 text-sm ">{{ nickname }}</span>
                  <span class="cursor-pointer text-gray-400 text-sm comment-edit" @click="editUser">[编辑]</span>
                </div>
                <div class="flex flex-row items-center justify-end">
                <span>
                    <IconSmiley></IconSmiley>
                </span>
                  <button class="bg-[#07c160] text-white pl-3 pr-3 pt-1 pb-1 ml-2 rounded-sm comment-submit" type="button" @click="submitComment">提交</button>
                </div>
              </div>
            </div>
          </div>

          <div v-for="comment in commentList">
            <div>
              <a :href="comment.url"><span class="text-[#576b95]">{{ comment.author }}</span></a>
              <span class="cursor-help comment-btn" @click="showCommentForm(comment.coid, comment.author, true)">: {{ comment.text }} </span>
            </div>
            <div v-for="children in comment.children">
              <a :href="children.url"><span class="text-[#576b95]">{{ children.author }}</span></a>
              <span><span>回复</span><span class="text-[#576b95]">{{ comment.author }}</span></span>
              <span class="cursor-help comment-btn" @click="showCommentForm(children.coid, children.author, true)">: {{ children.text }} </span>
            </div>
          </div>
          <div v-if="hasMoreComment">
            <a href="/detail?cid=" class="text-[#576b95]">更多评论</a>
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
import {ElMessage} from "element-plus";
import axios from "axios";
import time from '@/assets/time'

let ax = axios.create();

const props = defineProps(['data']);

const imgs = ref([]);
const text = ref('')
const url = ref('')
const formPlaceHolder = ref('评论');
const hasMoreComment = ref(false)

const isShowUserInfoForm = ref(true)
const nickName = localStorage.getItem('nickName')
const avatarUrl = localStorage.getItem('avatarUrl')

if (props.data) {
  if (props.data.fields && props.data.fields.friend_pictures && props.data.fields.friend_pictures.value !== '') {
    imgs.value = props.data.fields.friend_pictures.value.split(',');
  }

  if (imgs.value.length > 0) {
    url.value = imgs.value[0]
  }

  // 文章内容。正则过滤html标签
  if (props.data.text) {
    //text.value = props.data.text.replaceAll('<br>', '\r\n').replace(/<\/?.+?\/?>/g, '').replaceAll('\r\n', '<br>')
    text.value = props.data.text;
  }
}

getRecentComments();

const commentList = ref([])

function getRecentComments() {
  ax.get(import.meta.env.VITE_HTTP + '/index.php/api/comments?cid=' + props.data.cid)
      .then(data => {
        data.data.data.dataSet.forEach(item => {
          commentList.value.push(item);
        })
        if (commentList.value.length > 0) {
          hasComment.value = true;
          ShowCommentContainer();
        }
        if (data.data.data.pages > data.data.data.page) {
          // 显示更多。跳转到文章详情
          // hasMoreComment.value = true;
        }
      })
      .catch((error => {
      }))
}

/************评论表单参数***************/
const content = ref('')
const nickname = ref('')
const mail = ref('')
const userAddress = ref('')
const mailRule = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
const userAddressRule = /^https?:\/\/(([a-zA-Z0-9_-])+(\.)?)*(:\d+)?(\/((\.)?(\?)?=?&?[a-zA-Z0-9_-](\?)?)*)*$/i;
const parentCoid = ref(0);
const parentText = ref('');

/**
 * 提交评论
 */
function submitComment() {
  if (content.value === '') {
    ElMessage.error('评论内容不能为空')
    return;
  }
  if (nickname.value === '') {
    ElMessage.error('昵称不能为空')
    return;
  }
  if (mail.value === '') {
    ElMessage.error('邮箱不能为空')
    return;
  }
  if (!mailRule.test(mail.value)) {
    ElMessage.error('邮箱格式不正确')
    return;
  }
  if (userAddress.value === '') {
    ElMessage.error('网址不能为空')
    return;
  }
  if (!userAddressRule.test(userAddress.value)) {
    ElMessage.error('网址格式不正确')
    return;
  }
  const commentToken = ref('')
  // 先调用详情获取token
  ax.get(import.meta.env.VITE_HTTP + '/index.php/api/post?cid=' + props.data.cid)
      .then(data => {
        commentToken.value = data.data.data.csrfToken;
        // 提交评论
        let commentParam = {
          cid: props.data.cid,
          text: content.value,
          author: nickname.value,
          mail: mail.value,
          url: userAddress.value,
          token: commentToken.value,
          parent: parentCoid.value
        };
        ax.post(import.meta.env.VITE_HTTP + '/index.php/api/comment', commentParam)
            .then(data => {
              // 评论成功,拉取最新评论
              addUserInfo();
              getRecentComments();
            })
            .catch(error => {
              ShowCommentContainer();
            })
      })
      .catch(error => {
      })

}

function loadUserInfo() {
  nickname.value = localStorage.getItem('nickname');
  mail.value = localStorage.getItem('mail');
  userAddress.value = localStorage.getItem('userAddress');

  if (nickname.value && mail.value && userAddress.value) {
    isShowUserInfoForm.value = false;
  } else {
    isShowUserInfoForm.value = true;
  }
}

function addUserInfo() {
  content.value = '';
  localStorage.setItem('nickname', nickname.value);
  localStorage.setItem('mail', mail.value);
  localStorage.setItem('userAddress', userAddress.value);
  isShowUserInfoForm.value = false;
}

function editUser() {
  isShowUserInfoForm.value = true;
}

const showCommentTipField = ref(false);
const hasComment = ref(false)

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

function showCommentForm(coid, text, isShow) {
  loadUserInfo();

  parentCoid.value = coid;
  parentText.value = text;
  if (isShow === true) {
    showCommentFormField.value = true;
  } else {
    showCommentFormField.value = !showCommentFormField.value;
    ShowCommentContainer();
    showCommentTip();
  }

  if (parentText.value !== '') {
    formPlaceHolder.value = '@' + parentText.value;
  } else {
    formPlaceHolder.value = '评论'
  }

}

/**
 * 显示隐藏评论容器
 * @constructor
 */
const showCommentContainer = ref(false)

function ShowCommentContainer() {
  if (showCommentFormField.value === true || hasComment.value === true) {
    showCommentContainer.value = true;
  } else {
    showCommentContainer.value = false;
  }
}
</script>