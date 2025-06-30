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
} from 'primevue';
import EditPlanoContaDialog from '@/components/EditPlanoContaDialog.vue';
import type { PlanoConta } from '@/types/PlanoConta.ts';
import CreatePlanoContaDialog from '@/components/CreatePlanoContaDialog.vue';

const toast = useToast();
const confirm = useConfirm();
const request = useFetch();
const planosConta = ref<PlanoConta[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);

const selectedPlanoConta = ref<PlanoConta | null>(null);
const editFormVisible = ref(false);
const createFormVisible = ref(false);

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

const openEditForm = (planoConta: PlanoConta) => {
  selectedPlanoConta.value = planoConta;
  editFormVisible.value = true;
};

const deletePlanoConta = async (planoConta: PlanoConta) => {
  confirm.require({
    message: 'Você realmente deseja deletar esse registro?',
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
        await request.DELETE(`http://localhost:8000/api/planos-conta/${planoConta.id}`);
      } catch (error: any) {
        console.error(error.message);
      }

      toast.add({
        severity: 'info',
        summary: 'Confirmado',
        detail: 'Registro deletado com sucesso!',
        life: 3000,
      });
    },
    reject: () => {
      toast.add({
        severity: 'error',
        summary: 'Rejeitado',
        detail: 'Você não deletou o registro',
        life: 3000,
      });
    },
  });
};

onMounted(() => fetchPlanosConta());
</script>

<template>
  <header class="plano-contas-header">
    <h1>Plano Contas</h1>

    <Button label="Adicionar" icon="pi pi-plus" @click="createFormVisible = true" />
  </header>

  <div v-if="loading">
    <ProgressSpinner />
  </div>

  <Message v-if="error" severity="error">{{ error }}</Message>

  <DataTable :value="planosConta" tableStyle="min-width: 50rem">
    <Column field="id" header="Código"></Column>
    <Column field="descricao" header="Descrição"></Column>
    <Column field="tipo" header="Tipo"></Column>
    <Column header="Actions">
      <template #body="{ data }">
        <ButtonGroup>
          <Button label="Editar" icon="pi pi-pencil" @click="openEditForm(data)" />
          <Button
            label="Deletar"
            icon="pi pi-trash"
            severity="danger"
            @click="deletePlanoConta(data)"
          />
        </ButtonGroup>
      </template>
    </Column>
  </DataTable>

  <ConfirmDialog></ConfirmDialog>
  <CreatePlanoContaDialog v-model:visible="createFormVisible" />
  <EditPlanoContaDialog v-model:visible="editFormVisible" :plano-conta="selectedPlanoConta" />
</template>

<style scoped>
.plano-contas-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.error-msg {
  color: red;
}
</style>
