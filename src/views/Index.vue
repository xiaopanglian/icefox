<template>
  <Archive v-for="item in list" :data="item"></Archive>
</template>

<script setup>
import axios from "axios";
import Archive from "@/components/Archive.vue";
import {ref} from "vue";

const list = ref([]);

let ax = axios.create();
const page = 1;
const pageSize = 10;

const param = {showContent: true, page, pageSize};

ax.get('http://localhost/index.php/api/posts', {params: param})
    .then(data => {
      list.value = data.data.data.dataSet;
      console.log(data.data.data.dataSet)

      console.log(list)
    })
    .catch(error => {
      console.log(error)
    })
</script>