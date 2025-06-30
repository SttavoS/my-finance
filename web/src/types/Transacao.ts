import type { PlanoConta } from '@/types/PlanoConta.ts';

export type Transacao = {
  id: number;
  planoConta: PlanoConta;
  historico: string;
  valor: number;
  tipo: string;
  data: string;
};
