<script setup lang="ts">
import { useFetch } from '@/composables/useFetch.ts';
import { onMounted, ref } from 'vue';
import { Button, ButtonGroup, Column, DataTable } from 'primevue';

const request = useFetch();
const planosConta = ref([]);
const loading = ref(false);
const error = ref<string | null>(null);

const fetchPlanosConta = async () => {
  loading.value = true;
  try {
    planosConta.value = await request.GET('http://localhost:8000/api/planos-conta');
  } catch (error: any) {
    error.value = error.message;
    console.log(error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => fetchPlanosConta());
</script>

<template>
  <h1>Plano Contas</h1>

  <div v-if="loading">
    <ProgressSpinner />
  </div>

  <div v-if="error" class="error-msg">
    {{ error }}
  </div>

  <DataTable :value="planosConta" tableStyle="min-width: 50rem">
    <Column field="id" header="Código"></Column>
    <Column field="descricao" header="Descrição"></Column>
    <Column field="tipo" header="Tipo"></Column>
    <Column header="Actions">
      <template #body>
        <ButtonGroup>
          <Button label="Editar" icon="pi pi-pencil" />
          <Button label="Deletar" icon="pi pi-trash" />
        </ButtonGroup>
      </template>
    </Column>
  </DataTable>
</template>

<style scoped>
.error-msg {
  color: red;
}
</style>
