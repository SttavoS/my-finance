<script setup lang="ts">
import { useFetch } from '@/composables/useFetch.ts';
import { onMounted, ref } from 'vue';
import {
  Button,
  ButtonGroup,
  Column,
  DataTable,
  ConfirmDialog,
  useConfirm,
  useToast,
  Message,
  ProgressSpinner,
} from 'primevue';
import type { Transacao } from '@/types/Transacao.ts';
import CreateTransacaoDialog from '@/components/CreateTransacaoDialog.vue';
import EditTransacaoDialog from '@/components/EditTransacaoDialog.vue';

const toast = useToast();
const confirm = useConfirm();
const request = useFetch();
const transacoes = ref<Transacao[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);

const selectedTransacao = ref<Transacao | null>(null);
const editFormVisible = ref(false);
const createFormVisible = ref(false);

const fetchTransacoes = async () => {
  loading.value = true;
  error.value = null;
  try {
    transacoes.value = await request.GET('http://localhost:8000/api/transacoes');
  } catch (e: any) {
    error.value = e.message;
  } finally {
    loading.value = false;
  }
};

const openEditForm = (transacao: Transacao) => {
  selectedTransacao.value = transacao;
  editFormVisible.value = true;
};

const deleteTransacao = async (transacao: Transacao) => {
  confirm.require({
    message: 'Você realmente deseja deletar este registro?',
    header: 'Danger Zone',
    icon: 'pi pi-info-circle',
    rejectLabel: 'Cancelar',
    rejectProps: {
      label: 'Cancelar',
      severity: 'secondary',
      outlined: true,
    },
    acceptProps: {
      label: 'Deletar',
      severity: 'danger',
    },
    accept: async () => {
      try {
        await request.DELETE(`http://localhost:8000/api/transacoes/${transacao.id}`);
        toast.add({
          severity: 'info',
          summary: 'Confirmado',
          detail: 'Registro deletado com sucesso!',
          life: 3000,
        });
        await fetchTransacoes(); // Recarrega a lista
      } catch (e: any) {
        toast.add({
          severity: 'error',
          summary: 'Erro',
          detail: 'Ocorreu um erro ao deletar o registro.',
          life: 3000,
        });
      }
    },
  });
};

const handleCreated = async () => {
  createFormVisible.value = false;
  toast.add({
    severity: 'success',
    summary: 'Sucesso',
    detail: 'Transação criada com sucesso!',
    life: 3000,
  });
  await fetchTransacoes();
};

const handleUpdated = async () => {
  editFormVisible.value = false;
  toast.add({
    severity: 'success',
    summary: 'Sucesso',
    detail: 'Transação atualizada com sucesso!',
    life: 3000,
  });
  await fetchTransacoes();
};

onMounted(() => fetchTransacoes());
</script>

<template>
  <div class="page-container">
    <header class="page-header">
      <h1>Transações</h1>
      <Button label="Adicionar" icon="pi pi-plus" @click="createFormVisible = true" />
    </header>

    <div v-if="loading" class="spinner-container">
      <ProgressSpinner />
    </div>

    <Message v-if="error" severity="error">{{ error }}</Message>

    <DataTable v-if="!loading && !error" :value="transacoes" tableStyle="min-width: 50rem">
      <Column field="id" header="Código"></Column>
      <Column field="historico" header="Histórico"></Column>
      <Column field="valor" header="Valor">
        <template #body="{ data }">
          {{
            new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(
              data.valor,
            )
          }}
        </template>
      </Column>
      <Column field="data" header="Data">
        <template #body="{ data }">
          {{ new Date(data.data.date).toLocaleDateString('pt-BR') }}
        </template>
      </Column>
      <Column field="planoConta.descricao" header="Plano de Conta"></Column>
      <Column header="Ações">
        <template #body="{ data }">
          <ButtonGroup>
            <Button label="Editar" icon="pi pi-pencil" @click="openEditForm(data)" />
            <Button
              label="Deletar"
              icon="pi pi-trash"
              severity="danger"
              @click="deleteTransacao(data)"
            />
          </ButtonGroup>
        </template>
      </Column>
    </DataTable>

    <ConfirmDialog />
    <CreateTransacaoDialog
      v-if="createFormVisible"
      v-model:visible="createFormVisible"
      @created="handleCreated"
    />
    <EditTransacaoDialog
      v-if="editFormVisible"
      v-model:visible="editFormVisible"
      :transacao="selectedTransacao"
      @updated="handleUpdated"
    />
  </div>
</template>

<style scoped>
.page-container {
  width: 100%;
}
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}
.spinner-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
}
</style>
