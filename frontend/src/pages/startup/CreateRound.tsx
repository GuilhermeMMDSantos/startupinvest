import { FormEvent, useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { api, apiErrorMessage } from '../../lib/api';

export default function CreateRound() {
  const navigate = useNavigate();
  const [form, setForm] = useState({ targetAmount: '', equityOfferedPct: '', maxInvestors: '5', contractType: 'EQUITY_INVESTMENT' });
  const [pitchVideo, setPitchVideo] = useState<File | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);
  const [startupStatus, setStartupStatus] = useState<string | null>(null);

  useEffect(() => {
    api
      .get('/startups/me')
      .then(({ data }) => setStartupStatus(data.status))
      .catch((err) => setError(apiErrorMessage(err)));
  }, []);

  const minTicket = form.targetAmount && form.maxInvestors
    ? (Math.floor((Number(form.targetAmount) / Number(form.maxInvestors)) * 100) / 100).toFixed(2)
    : null;
  const canCreateRound = startupStatus === 'APPROVED';

  async function onSubmit(e: FormEvent) {
    e.preventDefault();
    setError(null);
    if (!canCreateRound) {
      setError('A startup precisa de ser aprovada pelo admin antes de abrir uma rodada');
      return;
    }
    if (!pitchVideo) {
      setError('Anexe o vídeo do pitch');
      return;
    }
    setLoading(true);
    try {
      const fd = new FormData();
      Object.entries(form).forEach(([k, v]) => fd.append(k, v));
      fd.append('pitchVideo', pitchVideo);
      const { data } = await api.post('/rounds', fd);
      navigate(`/startup/rounds/${data.id}/assessment`);
    } catch (err) {
      setError(apiErrorMessage(err));
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="max-w-lg mx-auto my-12 px-4">
      <div className="card">
        <h1 className="text-xl font-bold mb-1">Abrir rodada de investimento</h1>
        <p className="text-sm text-slate-600 mb-4">
          Após criar a rodada, terá de submeter o questionário de avaliação antes de a poder abrir a investidores.
        </p>
        {startupStatus && startupStatus !== 'APPROVED' && (
          <p className="mb-4 rounded-md border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-800">
            A sua startup está {startupStatus.toLowerCase().replaceAll('_', ' ')}. Só pode criar uma rodada depois da aprovação administrativa.
          </p>
        )}
        {error && <p className="text-red-600 text-sm mb-3">{error}</p>}
        <form onSubmit={onSubmit} className="space-y-4">
          <div>
            <label className="label">Valor procurado (USD)</label>
            <input
              className="input"
              type="number"
              min={1}
              step="0.01"
              value={form.targetAmount}
              onChange={(e) => setForm({ ...form, targetAmount: e.target.value })}
              disabled={!canCreateRound}
              required
            />
          </div>
          <div>
            <label className="label">Percentagem de capital oferecida (%)</label>
            <input
              className="input"
              type="number"
              min={0.01}
              max={100}
              step="0.01"
              value={form.equityOfferedPct}
              onChange={(e) => setForm({ ...form, equityOfferedPct: e.target.value })}
              disabled={!canCreateRound}
              required
            />
          </div>
          <div>
            <label className="label">Número máximo de investidores</label>
            <input
              className="input"
              type="number"
              min={2}
              value={form.maxInvestors}
              onChange={(e) => setForm({ ...form, maxInvestors: e.target.value })}
              disabled={!canCreateRound}
              required
            />
            {minTicket && <p className="text-xs text-slate-500 mt-1">Investimento mínimo por investidor: {minTicket} USD</p>}
          </div>
          <div>
            <label className="label">Tipo de contrato</label>
            <select className="input" value={form.contractType} onChange={(e) => setForm({ ...form, contractType: e.target.value })} disabled={!canCreateRound}>
              <option value="EQUITY_INVESTMENT">Investimento direto em participação social</option>
              <option value="CONVERTIBLE_NOTE">Mútuo conversível</option>
            </select>
          </div>
          <div>
            <label className="label">Vídeo do pitch</label>
            <input className="input" type="file" accept=".mp4,.mov,.webm" onChange={(e) => setPitchVideo(e.target.files?.[0] ?? null)} disabled={!canCreateRound} required />
          </div>
          <button className="btn-primary w-full" disabled={loading || !canCreateRound}>
            {loading ? 'A criar...' : 'Criar rodada'}
          </button>
        </form>
      </div>
    </div>
  );
}
