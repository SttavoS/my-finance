<script setup lang="ts">
import { ref, onMounted } from 'vue';
import Chart from 'primevue/chart';
import Message from 'primevue/message';
import DatePicker from 'primevue/datepicker';
import Button from 'primevue/button';
import { useFetch } from '@/composables/useFetch.ts';
import type { DashboardData } from '@/types/DashboardData.ts';

const request = useFetch();

const chartData = ref();
const chartOptions = ref();
const dataInicio = ref<Date | null>(null);
const dataFim = ref<Date | null>(null);

const dateFormat = (date: Date) => {
  const ano = date.getFullYear();
  const mes = (date.getMonth() + 1).toString().padStart(2, '0');
  const dia = date.getDate().toString().padStart(2, '0');

  return `${ano}-${mes}-${dia}`;
};

async function fetchChartData() {
  const params = new URLSearchParams();
  if (dataInicio.value) {
    params.append('dataInicio', dateFormat(dataInicio.value));
  }
  if (dataFim.value) {
    params.append('dataFim', dateFormat(dataFim.value));
  }

  // Simula a chamada à API
  const response = await request.GET(`http://localhost:8000/api/dashboard?${params.toString()}`);

  if (!response) {
    chartData.value = null;
    return;
  }

  updateChart(response);
}

function updateChart(data: DashboardData[]) {
  const documentStyle = getComputedStyle(document.documentElement);
  const labels = data.map(item => item.descricao);
  const values = data.map(item => item.total);

  // Array de cores base do seu tema. Adicione quantas quiser.
  const baseColors = [
    documentStyle.getPropertyValue('--p-cyan-500'),
    documentStyle.getPropertyValue('--p-orange-500'),
    documentStyle.getPropertyValue('--p-gray-500'),
    documentStyle.getPropertyValue('--p-blue-500'),
    documentStyle.getPropertyValue('--p-green-500'),
    documentStyle.getPropertyValue('--p-yellow-500'),
    documentStyle.getPropertyValue('--p-pink-500'),
    documentStyle.getPropertyValue('--p-indigo-500'),
    documentStyle.getPropertyValue('--p-teal-500'),
    documentStyle.getPropertyValue('--p-purple-500'),
  ];

  // Gera as cores dinamicamente, repetindo a paleta se necessário
  const dynamicColors = labels.map((_, index) => baseColors[index % baseColors.length]);
  const dynamicHoverColors = labels.map((_, index) =>
    baseColors[index % baseColors.length].replace('500', '400'),
  );

  chartData.value = {
    labels: labels,
    datasets: [
      {
        data: values,
        backgroundColor: dynamicColors,
        hoverBackgroundColor: dynamicHoverColors,
      },
    ],
  };
}

onMounted(() => {
  const now = new Date();
  dataFim.value = now;
  dataInicio.value = new Date(now.getFullYear(), now.getMonth() - 3, 1);

  fetchChartData();

  const textColor = getComputedStyle(document.documentElement).getPropertyValue('--p-text-color');
  chartOptions.value = {
    plugins: {
      legend: {
        labels: {
          color: textColor,
        },
      },
    },
  };
});
</script>

<template>
  <section class="dashboard">
    <h1 class="title">Dashboard</h1>
    <div class="filters">
      <!-- Filtros de Data -->
      <div class="flex flex-col">
        <label for="dataInicio">Data Início</label>
        <DatePicker id="dataInicio" v-model="dataInicio" dateFormat="yy-mm-dd" />
      </div>
      <div class="flex flex-col">
        <label for="dataFim">Data Fim</label>
        <DatePicker id="dataFim" v-model="dataFim" dateFormat="yy-mm-dd" />
      </div>
      <Button label="Filtrar" icon="pi pi-search" @click="fetchChartData" />
    </div>

    <Chart v-if="chartData" type="pie" :data="chartData" :options="chartOptions" class="chart" />
    <Message v-else severity="info">Nenhum dado encontrado para o período</Message>
  </section>
</template>

<style scoped>
.dashboard {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  gap: 1rem;
}

.title {
  font-size: 2.5rem;
  font-weight: 700;
}

.filters {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.chart {
  max-width: 480px;
}
</style>
