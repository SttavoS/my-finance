<script setup lang="ts">
import { defineProps, defineEmits, ref, watch } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import type { PlanoConta } from '@/types/PlanoConta.ts';
import { useFetch } from '@/composables/useFetch.ts';

const request = useFetch();
const { planoConta } = defineProps<{
  visible: boolean;
  planoConta: PlanoConta | null;
}>();

const emit = defineEmits(['update:visible']);

const descricao = ref('');
const tipo = ref('');

const options = [
  { name: 'Despesa', value: 'D' },
  { name: 'Receita', value: 'R' },
];

watch(
  () => planoConta,
  newValue => {
    if (newValue) {
      descricao.value = newValue.descricao;
      tipo.value = newValue.tipo;
    }
  },
  { immediate: true },
);

const updatePlanosConta = async () => {
  try {
    await request.PUT(`http://localhost:8000/api/planos-conta/${planoConta?.id}`, {
      descricao: descricao.value,
      tipo: tipo.value,
    });

    closeDialog();
  } catch (e: any) {
    console.error(e.message);
  }
};

const closeDialog = () => {
  emit('update:visible', false);
};
</script>

<template>
  <Dialog :visible :style="{ width: '25rem' }" header="Editar Plano de Conta" modal>
    <div class="edit-form">
      <div class="control-group">
        <label for="descricao">Descrição</label>
        <InputText id="descricao" v-model="descricao" autocomplete="off" />
      </div>
      <div class="control-group">
        <label for="email">Tipo</label>
        <Select
          v-model="tipo"
          :options="options"
          option-label="name"
          option-value="value"
          placeholder="Selecione"
        />
      </div>
      <div class="control-action">
        <Button type="button" severity="secondary" @click="closeDialog">Cancelar</Button>
        <Button type="button" @click="updatePlanosConta">Salvar</Button>
      </div>
    </div>
  </Dialog>
</template>

<style scoped>
.edit-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.control-group {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.control-group input,
.control-group select {
  width: 200px;
}

.control-action {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}
</style>
