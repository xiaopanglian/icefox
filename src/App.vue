<script setup>
import Header from './components/Header.vue'

</script>

<template>
  <main class="container bg-white pyq-container">
    <Suspense>
      <Header></Header>
    </Suspense>
    <Suspense>
      <RouterView></RouterView>
    </Suspense>
  </main>
</template>

<style scoped></style>
