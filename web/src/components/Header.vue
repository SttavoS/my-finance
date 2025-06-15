<script setup lang="ts">
import { ref } from 'vue';
import { Menubar } from 'primevue';

const items = ref([
  {
    label: 'Dashboard',
    icon: 'pi pi-home',
    route: '/dashboard',
  },
  {
    label: 'Plano de Contas',
    icon: 'pi pi-wallet',
    route: '/plano-contas',
  },
  {
    label: 'Transações',
    icon: 'pi pi-credit-card',
    route: '/transacoes',
  },
]);
</script>

<template>
  <header class="main-header">
    <Menubar :model="items">
      <template #item="{ item, props }">
        <router-link v-slot="{ href, navigate }" :to="item.route" custom>
          <a :href="href" v-bind="props.action" @click="navigate">
            <span :class="item.icon" />
            <span>{{ item.label }}</span>
          </a>
        </router-link>
      </template>
    </Menubar>
  </header>
</template>

<style scoped>
.main-header {
  display: flex;
}
</style>
