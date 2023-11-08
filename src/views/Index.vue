<template>
  <div>
    <Archive v-for="item in list" :data="item" :showAllComment="false" :avatarUrl="avatarUrl" :nickName="nickName">
    </Archive>
  </div>
  <div class="flex justify-center pt-3 pb-3">
    <span @click="loadMore()">{{ loadingText }}</span>
  </div>
</template>

<script setup>
import axios from "axios";
import Archive from "@/components/Archive.vue";
import { computed, ref, getCurrentInstance } from "vue";
import { ElMessage } from "element-plus";

const list = ref([]);

let ax = axios.create();
const page = ref(0);
const pages = ref(10);
const pageSize = 5;
const noMore = computed(() => page.value >= pages.value)
const loading = ref(false)
const loadingText = ref('点击加载更多')
const hasMore = ref(true)

const loadMore = async () => {
  if (hasMore.value == false) {
    return;
  }
  loadingText.value = '加载中'
  loading.value = true;

  page.value += 1;
  const param = { showContent: true, page: page.value, pageSize };
  await ax.get(import.meta.env.VITE_HTTP + '/index.php/api/posts', { params: param })
    .then(data => {
      data.data.data.dataSet.forEach(item => {
        list.value.push(item);
      });

      pages.value = data.data.data.pages;

      loadingText.value = '点击加载更多'
      loading.value = false;

      if (noMore.value === true) {
        loadingText.value = '没有更多数据'
        hasMore.value = false;
      }
    })
    .catch(error => {
      ElMessage.error(error)
    })
}

loadMore();

const bus = getCurrentInstance().appContext.config.globalProperties.$bus;
const avatarUrl = ref(localStorage.getItem('avatarUrl'));
const nickName = ref(localStorage.getItem('nickName'));
// 更新头像
bus.on('message', (message) => {
  avatarUrl.value = message.avatarUrl;
  nickName.value = message.nickName;
});
</script>