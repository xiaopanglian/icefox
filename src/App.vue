<script setup>
import Header from './components/Header.vue'

</script>

<template>
  <main class="container bg-white pyq-container">
    <Suspense>
      <Header></Header>
    </Suspense>
    <RouterView></RouterView>
  </main>
</template>

<style scoped></style>
