import type { PlanoConta } from '@/types/PlanoConta';

export interface Transacao {
  id: number;
  planoConta: PlanoConta;
  historico: string;
  valor: number;
  data: string;
}
