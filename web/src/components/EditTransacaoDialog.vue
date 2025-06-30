<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import { Button, DatePicker, Dialog, InputNumber, InputText, Select } from 'primevue';
import type { Transacao } from '@/types/Transacao.ts';
import type { PlanoConta } from '@/types/PlanoConta.ts';
import { useFetch } from '@/composables/useFetch.ts';

const props = defineProps<{
  visible: boolean;
  transacao: Transacao | null;
}>();

const emit = defineEmits(['update:visible', 'updated']);

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

watch(
  () => props.transacao,
  newValue => {
    if (newValue) {
      historico.value = newValue.historico;
      valor.value = newValue.valor;
      data.value = new Date(newValue.data);
      planoContaId.value = newValue.planoConta.id;
    }
  },
  { immediate: true },
);

const updateTransacao = async () => {
  if (!props.transacao || !historico.value || !valor.value || !data.value || !planoContaId.value) {
    alert('Por favor, preencha todos os campos.');
    return;
  }

  try {
    await request.PUT(`http://localhost:8000/api/transacoes/${props.transacao.id}`, {
      historico: historico.value,
      valor: valor.value,
      data: data.value.toISOString().split('T')[0],
      planoContaId: planoContaId.value,
    });
    emit('updated');
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
    :visible="visible"
    :style="{ width: '30rem' }"
    header="Editar Transação"
    modal
    @update:visible="closeDialog"
  >
    <div class="form-container">
      <div class="form-group">
        <label for="historico">Histórico</label>
        <InputText id="historico" v-model="historico" autocomplete="off" />
      </div>
      <div class="form-group">
        <label for="valor">Valor</label>
        <InputNumber id="valor" v-model="valor" mode="currency" currency="BRL" locale="pt-BR" />
      </div>
      <div class="form-group">
        <label for="data">Data</label>
        <DatePicker id="data" v-model="data.date" dateFormat="dd/mm/yy" />
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
        <Button type="button" @click="updateTransacao">Salvar</Button>
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
