<template>
  <header class="container pb-8">
    <div class="">
      <img src="http://0ru.cn/usr/uploads/2023/08/405344545.jpg" alt="top img" class="w-full object-cover"
           style="height: calc(100vh / 3) ;"/>
    </div>

    <div class="relative w-full">
      <div class="absolute right-0 bottom-[-16px] flex flex-row h-[64px] items-center w-full justify-end pr-8">
        <div class="text-white pr-5">
          {{ setting.value.title }}
        </div>
        <img src="http://0ru.cn/usr/uploads/2023/08/523224250.png" alt="logo"
             class="w-[64px] h-[64px] rounded-lg object-cover"/>
      </div>
    </div>
  </header>
</template>

<script setup>
import {reactive, ref} from "vue";
import axios from "axios";

let ax = axios.create();

const setting = reactive({})
/**
 * 获取系统设置
 * @returns {Promise<void>}
 */
const getSettings = async () => {
  await ax.get(import.meta.env.VITE_HTTP + '/index.php/api/settings')
      .then(data => {
        setting.value = data.data.data;
      })
      .catch(error => {
      })
}
await getSettings();

const getThemeOption = async () =>{
  await ax.get(import.meta.env.VITE_HTTP + '/index.php/themeOption')
      .then(data => {
        console.log(data)
      })
      .catch(error => {
      })
}

await getThemeOption();
</script>