<template>
  <div v-infinite-scroll="loadMore" :infinite-scroll-disabled="disabled">
    <Archive v-for="item in list" :data="item"></Archive>
  </div>
  <div class="flex justify-center">
    {{ loadingText }}
  </div>
</template>

<script setup>
import axios from "axios";
import Archive from "@/components/Archive.vue";
import {computed, ref} from "vue";

const list = ref([]);

let ax = axios.create();
const page = ref(0);
const pages = ref(10);
const pageSize = 5;
const noMore = computed(() => page.value >= pages.value)
const disabled = computed(() => loading.value || noMore.value)
const loading = ref(false)
const loadingText = ref('下拉加载更多')



const loadMore = async () => {
  loadingText.value = '加载中'
  loading.value = true;

  page.value += 1;
  const param = {showContent: true, page: page.value, pageSize};
  await ax.get(import.meta.env.VITE_HTTP + '/index.php/api/posts', {params: param})
      .then(data => {
        data.data.data.dataSet.forEach(item => {
          list.value.push(item);
        });

        pages.value = data.data.data.pages;

        loadingText.value = '下拉加载更多'
        loading.value = false;

        if (noMore.value === true) {
          loadingText.value = '没有更多数据'
        }
      })
      .catch(error => {

      })
}


</script>