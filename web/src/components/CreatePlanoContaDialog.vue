<script setup lang="ts">
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Select from 'primevue/select';
import Dialog from 'primevue/dialog';
import { defineEmits, defineProps, ref } from 'vue';
import type { PlanoConta } from '@/types/PlanoConta.ts';
import { useFetch } from '@/composables/useFetch.ts';

const request = useFetch();
defineProps<{
  visible: boolean;
}>();

const planoConta = ref<PlanoConta>({
  id: 0,
  descricao: '',
  tipo: '',
});

const options = [
  { name: 'Despesa', value: 'D' },
  { name: 'Receita', value: 'R' },
];

const savePlanosConta = async () => {
  try {
    await request.POST(`http://localhost:8000/api/planos-conta`, {
      descricao: planoConta.value.descricao,
      tipo: planoConta.value.tipo,
    });

    closeDialog();
  } catch (e: any) {
    console.error(e.message);
  }
};

const emit = defineEmits(['update:visible']);
const closeDialog = () => {
  emit('update:visible', false);
};
</script>

<template>
  <Dialog :visible :style="{ width: '25rem' }" header="Editar Plano de Conta" modal>
    <div class="create-form">
      <div class="control-group">
        <label for="descricao">Descrição</label>
        <InputText id="descricao" v-model="planoConta.descricao" autocomplete="off" />
      </div>
      <div class="control-group">
        <label for="email">Tipo</label>
        <Select
          v-model="planoConta.tipo"
          :options="options"
          option-label="name"
          option-value="value"
          placeholder="Selecione"
        />
      </div>
      <div class="control-action">
        <Button type="button" severity="secondary" @click="closeDialog">Cancelar</Button>
        <Button type="button" @click="savePlanosConta">Salvar</Button>
      </div>
    </div>
  </Dialog>
</template>

<style scoped>
.create-form {
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
