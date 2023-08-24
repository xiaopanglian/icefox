<template>
  <div v-infinite-scroll="loadMore">
    <Archive v-for="item in list" :data="item"></Archive>
  </div>
  <div>
    加载中
  </div>
</template>

<script setup>
import axios from "axios";
import Archive from "@/components/Archive.vue";
import {ref} from "vue";

const list = ref([]);

let ax = axios.create();
const page = ref(0);
const pageSize = 5;
const canLoad = ref(true)

const loadMore = () => {
  console.log('loadMore')
  if (canLoad.value === false) {
    console.log('none')
    return;
  }
  page.value += 1;
  const param = {showContent: true, page: page.value, pageSize};
  ax.get('http://localhost:8008/index.php/api/posts', {params: param})
      .then(data => {
        data.data.data.dataSet.forEach(item => {
          list.value.push(item);
        });

        if (data.data.data.page >= data.data.data.pages) {
          canLoad.value = false;
        }
      })
      .catch(error => {

      })
}


</script>