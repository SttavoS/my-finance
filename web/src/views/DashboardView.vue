<script setup lang="ts">
import { reactive } from 'vue'
import { Column, DataTable,  Button, ButtonGroup } from 'primevue'

const products = reactive({
  items: [
    { id: 1, name: 'Notebook', price: 6000 },
    { id: 2, name: 'Smartphone', price: 1899 },
    { id: 3, name: 'Monitor', price: 1100 },
    { id: 4, name: 'Mouse', price: 610 },
    { id: 5, name: 'Keyboard', price: 550 },
  ],
})
</script>

<template>
  <section class="products-table">
    <div>
      <Button>Adicionar</Button>
    </div>
    <DataTable :value="products.items" tableStyle="min-width: 50rem">
      <Column field="id" header="Id"></Column>
      <Column field="name" header="Name"></Column>
      <Column field="price" header="Price"></Column>
      <Column header="Actions">
        <template #body="slotProps">
          <ButtonGroup>
            <Button label="Editar" icon="pi pi-pencil"/>
            <Button label="Deletar" icon="pi pi-trash"/>
          </ButtonGroup>
        </template>
      </Column>
    </DataTable>
  </section>

</template>

<style scoped>
.products-table {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  gap: 1rem;
}
</style>