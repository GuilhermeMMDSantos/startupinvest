import { FormEvent, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { api, apiErrorMessage } from '../../lib/api';

interface FormState {
  [key: string]: string | boolean;
}

const NUMERIC_FIELDS: [string, string][] = [
  ['marketGrowthRate', 'Taxa de crescimento do mercado (%)'],
  ['competitorsMarketShare', 'Participação de mercado dos concorrentes (%)'],
  ['directCompetitorsCount', 'Número de concorrentes diretos'],
  ['targetMarketSize', 'Tamanho do mercado alvo (USD)'],
  ['inflationRate', 'Taxa de inflação (%)'],
  ['interestRate', 'Taxa de juro (%)'],
  ['unemploymentRate', 'Taxa de desemprego (%)'],
  ['customerRetentionRate', 'Taxa de retenção de clientes (%)'],
  ['customerBaseGrowth', 'Crescimento da base de clientes (%)'],
  ['initialAdoptionRate', 'Taxa de adoção inicial (%)'],
  ['purchaseRecurrence', 'Recorrência de compra (%)'],
  ['ltv', 'LTV - valor vitalício do cliente (USD)'],
  ['cac', 'CAC - custo de aquisição de cliente (USD)'],
  ['avgTicket', 'Ticket médio (USD)'],
  ['revenueGrowthRate', 'Taxa de crescimento da receita (%)'],
  ['roi', 'ROI (%)'],
  ['grossMargin', 'Margem bruta (%)'],
  ['netMargin', 'Margem líquida (%)'],
  ['receivableDays', 'Tempo médio de recebimento (dias)'],
  ['revenueSourcesCount', 'Número de fontes de receita'],
  ['avgExperienceYears', 'Média de experiência da equipa (anos)'],
  ['teamSize', 'Tamanho da equipa'],
  ['managementExpCount', 'Nº de fundadores com experiência em gestão'],
  ['technicalCount', 'Nº de fundadores com perfil técnico'],
  ['weeklyWorkHours', 'Horas de trabalho por semana (fundadores)'],
  ['timeWorkingTogetherYears', 'Tempo de equipa a trabalhar junta (anos)'],
  ['automationLevel', 'Grau de automação dos processos (%)'],
  ['previousFundingRounds', 'Nº de rodadas de investimento anteriores'],
];

const BOOLEAN_FIELDS: [string, string][] = [
  ['revenueProduct', 'Receita por venda de produto'],
  ['revenueSubscription', 'Receita por assinatura'],
  ['revenueAdvertising', 'Receita por publicidade'],
  ['revenueOther', 'Outras fontes de receita'],
  ['hasIntellectualProperty', 'Possui propriedade intelectual (patentes, marcas)'],
  ['hasExclusiveTechnology', 'Possui tecnologia exclusiva'],
  ['hasExclusiveDistributionChannels', 'Tem acesso a canais de distribuição exclusivos'],
  ['participatedIncubation', 'Participou em incubadora/aceleradora'],
];

function initialState(): FormState {
  const state: FormState = { businessModelType: 'B2C' };
  NUMERIC_FIELDS.forEach(([key]) => (state[key] = '0'));
  BOOLEAN_FIELDS.forEach(([key]) => (state[key] = false));
  return state;
}

export default function RoundAssessment() {
  const { roundId } = useParams();
  const navigate = useNavigate();
  const [form, setForm] = useState<FormState>(initialState());
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  async function onSubmit(e: FormEvent) {
    e.preventDefault();
    setError(null);
    setLoading(true);
    try {
      const payload: Record<string, unknown> = { businessModelType: form.businessModelType };
      NUMERIC_FIELDS.forEach(([key]) => (payload[key] = Number(form[key] || 0)));
      BOOLEAN_FIELDS.forEach(([key]) => (payload[key] = Boolean(form[key])));
      await api.post(`/rounds/${roundId}/assessment`, payload);
      navigate(`/startup/rounds/${roundId}`);
    } catch (err) {
      setError(apiErrorMessage(err));
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="max-w-3xl mx-auto px-4 py-10">
      <h1 className="text-2xl font-bold mb-1">Questionário de avaliação da startup</h1>
      <p className="text-sm text-slate-600 mb-6">
        Estes dados alimentam o modelo estatístico que estima o potencial de crescimento da startup e a
        probabilidade de atingir uma Série B, e são mostrados aos investidores como apoio à decisão.
      </p>
      {error && <p className="text-red-600 text-sm mb-3">{error}</p>}
      <form onSubmit={onSubmit} className="space-y-6">
        <div className="card">
          <label className="label">Modelo de negócio</label>
          <select className="input max-w-xs" value={form.businessModelType as string} onChange={(e) => setForm({ ...form, businessModelType: e.target.value })}>
            <option value="B2C">B2C</option>
            <option value="B2B">B2B</option>
            <option value="B2B2C">B2B2C</option>
          </select>
        </div>

        <div className="card">
          <h2 className="font-semibold mb-3">Indicadores</h2>
          <div className="grid sm:grid-cols-2 gap-4">
            {NUMERIC_FIELDS.map(([key, label]) => (
              <div key={key}>
                <label className="label text-xs">{label}</label>
                <input
                  className="input"
                  type="number"
                  step="0.01"
                  value={form[key] as string}
                  onChange={(e) => setForm({ ...form, [key]: e.target.value })}
                />
              </div>
            ))}
          </div>
        </div>

        <div className="card">
          <h2 className="font-semibold mb-3">Características</h2>
          <div className="grid sm:grid-cols-2 gap-2">
            {BOOLEAN_FIELDS.map(([key, label]) => (
              <label key={key} className="text-sm flex items-center gap-2">
                <input type="checkbox" checked={form[key] as boolean} onChange={(e) => setForm({ ...form, [key]: e.target.checked })} />
                {label}
              </label>
            ))}
          </div>
        </div>

        <button className="btn-primary w-full" disabled={loading}>
          {loading ? 'A calcular avaliação...' : 'Submeter avaliação'}
        </button>
      </form>
    </div>
  );
}
