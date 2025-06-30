<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { Button, DatePicker, Dialog, InputNumber, InputText, Select } from 'primevue';
import { useFetch } from '@/composables/useFetch.ts';
import type { PlanoConta } from '@/types/PlanoConta';

const emit = defineEmits(['update:visible', 'created']);

const request = useFetch();
const historico = ref('');
const valor = ref<number | null>(null);
const data = ref<Date | null>(null);
const planoContaId = ref<number | null>(null);
const planosConta = ref<PlanoConta[]>([]);

const fetchPlanosConta = async () => {
  try {
    planosConta.value = await request.GET('http://localhost:8000/api/planos-conta');
  } catch (e: any) {
    console.error(e.message);
  }
};

const createTransacao = async () => {
  if (!historico.value || !valor.value || !data.value || !planoContaId.value) {
    alert('Por favor, preencha todos os campos.');
    return;
  }

  try {
    await request.POST('http://localhost:8000/api/transacoes', {
      historico: historico.value,
      valor: valor.value,
      data: data.value.toISOString().split('T')[0], // Formato YYYY-MM-DD
      planoContaId: planoContaId.value,
    });
    emit('created');
  } catch (e: any) {
    console.error(e.message);
  }
};

const closeDialog = () => {
  emit('update:visible', false);
};

onMounted(fetchPlanosConta);
</script>

<template>
  <Dialog
    :visible="true"
    :style="{ width: '30rem' }"
    header="Adicionar Transação"
    modal
    @update:visible="closeDialog"
  >
    <div class="form-container">
      <div class="form-group">
        <label for="historico">Descrição</label>
        <InputText id="historico" v-model="historico" autocomplete="off" />
      </div>
      <div class="form-group">
        <label for="valor">Valor</label>
        <InputNumber id="valor" v-model="valor" mode="currency" currency="BRL" locale="pt-BR" />
      </div>
      <div class="form-group">
        <label for="data">Data</label>
        <DatePicker id="data" v-model="data" dateFormat="dd/mm/yy" />
      </div>
      <div class="form-group">
        <label for="plano-conta">Plano de Conta</label>
        <Select
          id="plano-conta"
          v-model="planoContaId"
          :options="planosConta"
          option-label="descricao"
          option-value="id"
          placeholder="Selecione"
        />
      </div>
      <div class="form-actions">
        <Button type="button" severity="secondary" @click="closeDialog">Cancelar</Button>
        <Button type="button" @click="createTransacao">Salvar</Button>
      </div>
    </div>
  </Dialog>
</template>

<style scoped>
.form-container {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  padding-top: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-group label {
  font-weight: bold;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 1rem;
}
</style>
