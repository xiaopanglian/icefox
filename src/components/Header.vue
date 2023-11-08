<template>
  <header class="container pb-8">
    <div class="">
      <img :src="backgroundImageUrl" alt="top img" class="w-full object-cover" style="height: calc(100vh / 3) ;" />
    </div>

    <div class="relative w-full">
      <div class="absolute right-0 bottom-[-16px] flex flex-row h-[64px] items-center w-full justify-end pr-8">
        <div class="text-white pr-5">
          {{ nickName }}
        </div>
        <img :src="avatarUrl" alt="logo" class="w-[64px] h-[64px] rounded-lg object-cover" />
      </div>
    </div>
  </header>
</template>

<script setup>
import { reactive, ref } from "vue";
import axios from "axios";
import locutusPhpUnserialize from 'locutus/php/var/unserialize'
import { getCurrentInstance } from "vue";
const bus = getCurrentInstance().appContext.config.globalProperties.$bus;

let ax = axios.create();

const setting = reactive({})
const nickName = ref('')
const avatarUrl = ref('')
const backgroundImageUrl = ref('')
/**
 * 获取系统设置
 * @returns {Promise<void>}
 */
const getSettings = async () => {
  await ax.get(import.meta.env.VITE_HTTP + '/index.php/api/settings')
    .then(data => {
      setting.value = data.data.data;

      document.title = setting.value.title
    })
    .catch(error => {
    })
}
await getSettings();

const getThemeOption = async () => {
  await ax.get(import.meta.env.VITE_HTTP + '/index.php/api/themeOption')
    .then(data => {
      let themeIcefox = data.data.data;

      if (themeIcefox.length > 0) {
        let themeOption = themeIcefox[0].value;

        let themeOptionValue = locutusPhpUnserialize(themeOption)
        nickName.value = themeOptionValue.nickName;
        avatarUrl.value = themeOptionValue.avatarUrl;
        backgroundImageUrl.value = themeOptionValue.backgroundImageUrl;

        localStorage.setItem('nickName', nickName.value);
        localStorage.setItem('avatarUrl', avatarUrl.value);

        bus.emit('message', { nickName: nickName.value, avatarUrl: avatarUrl.value });
      }
    })
    .catch(error => {
    })
}

await getThemeOption();
</script>