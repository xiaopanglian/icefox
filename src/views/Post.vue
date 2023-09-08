<template>
    <Suspense>
        <Archive :data="archiveData.value" :showAllComment="true"></Archive>
    </Suspense>
</template>
<script setup>
import axios from "axios";
import Archive from "@/components/Archive.vue";
import { reactive, ref } from "vue";

const archiveData = reactive({})
const param = {
    cid: 64
}
const loadPost = async () => {
    let ax = axios.create();
    await ax.get(import.meta.env.VITE_HTTP + '/index.php/api/post', { params: param })
        .then(data => {
            archiveData.value = data.data.data;
        })
        .catch(error => {

        })
}

await loadPost();
</script>