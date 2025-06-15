<script setup lang="ts">
import Header from '@/components/Header.vue';
</script>

<template>
  <div class="container">
    <Header />
    <main>
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
.container {
  max-width: 1200px;
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin: 50px auto 0;
}
</style>
