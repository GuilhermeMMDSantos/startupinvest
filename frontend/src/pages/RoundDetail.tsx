import { FormEvent, useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { api, apiErrorMessage, fileUrl } from '../lib/api';
import type { RoundDto, StartupDto } from '../types';
import ScoringBadge from '../components/ScoringBadge';
import { useAuth } from '../context/AuthContext';

export default function RoundDetail() {
  const { id } = useParams();
  const { user } = useAuth();
  const navigate = useNavigate();
  const [round, setRound] = useState<RoundDto | null>(null);
  const [startup, setStartup] = useState<StartupDto | null>(null);
  const [amount, setAmount] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [info, setInfo] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    api.get(`/rounds/${id}`).then(({ data }) => {
      setRound(data);
      api.get(`/startups/${data.startupId}/public`).then((r) => setStartup(r.data)).catch(() => {});
    });
  }, [id]);

  if (!round) return <div className="max-w-4xl mx-auto px-4 py-10">A carregar...</div>;

  const pct = Math.min(100, (round.amountRaised / round.targetAmount) * 100);

  async function invest(e: FormEvent) {
    e.preventDefault();
    setError(null);
    setInfo(null);
    if (!user) {
      navigate('/login');
      return;
    }
    setLoading(true);
    try {
      const { data } = await api.post(`/rounds/${round!.id}/investments`, { amount: Number(amount) });
      navigate(`/investor/investments/${data.id}`);
    } catch (err) {
      setError(apiErrorMessage(err));
    } finally {
      setLoading(false);
    }
  }

  async function startConversation() {
    if (!user) {
      navigate('/login');
      return;
    }
    try {
      const { data } = await api.post(`/conversations/start`, null, { params: { roundId: round!.id } });
      navigate(`/investor/messages/${data.id}`);
    } catch (err) {
      setError(apiErrorMessage(err));
    }
  }

  return (
    <div className="max-w-4xl mx-auto px-4 py-10 space-y-6">
      <div>
        <h1 className="text-2xl font-bold">{round.startupName}</h1>
        <p className="text-slate-500">{round.startupSector ?? 'Sector não indicado'}</p>
      </div>

      <div className="aspect-video bg-black rounded-lg overflow-hidden">
        <video controls className="w-full h-full" src={fileUrl(round.pitchVideoPath)} />
      </div>

      {startup?.shortDescription && <p className="text-slate-700">{startup.shortDescription}</p>}

      <div className="card">
        <div className="w-full bg-slate-100 rounded-full h-3 mb-2">
          <div className="bg-brand-600 h-3 rounded-full" style={{ width: `${pct}%` }} />
        </div>
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
          <div>
            <p className="text-slate-500">Angariado</p>
            <p className="font-semibold">{round.amountRaised.toLocaleString()} USD</p>
          </div>
          <div>
            <p className="text-slate-500">Meta</p>
            <p className="font-semibold">{round.targetAmount.toLocaleString()} USD</p>
          </div>
          <div>
            <p className="text-slate-500">Capital oferecido</p>
            <p className="font-semibold">{round.equityOfferedPct}%</p>
          </div>
          <div>
            <p className="text-slate-500">Mínimo por investidor</p>
            <p className="font-semibold">{round.minTicket.toLocaleString()} USD</p>
          </div>
        </div>
        <p className="text-xs text-slate-500 mt-2">
          Tipo de contrato: {round.contractType === 'CONVERTIBLE_NOTE' ? 'Mútuo conversível' : 'Investimento direto em participação social'} · Máx.{' '}
          {round.maxInvestors} investidores
        </p>
      </div>

      {round.scoring && (
        <div className="card">
          <div className="flex items-center justify-between mb-3">
            <h2 className="font-semibold">Avaliação de potencial de crescimento</h2>
            <ScoringBadge likelihood={round.scoring.seriesBLikelihood} score={round.scoring.growthPotentialScore} />
          </div>
          <p className="text-xs text-slate-500 mb-3">
            Índice estatístico ponderado (0-100) que estima a probabilidade desta startup atingir uma Série B, com
            base em mercado, tração, financeiro, equipa e dificuldade de réplica.
          </p>
          <div className="grid sm:grid-cols-2 gap-4">
            <div>
              <p className="text-sm font-medium text-green-700 mb-1">Pontos fortes</p>
              <ul className="text-sm text-slate-600 space-y-0.5">
                {Object.entries(round.scoring.strengths).map(([k, v]) => (
                  <li key={k}>
                    {k}: {v}
                  </li>
                ))}
                {Object.keys(round.scoring.strengths).length === 0 && <li className="text-slate-400">-</li>}
              </ul>
            </div>
            <div>
              <p className="text-sm font-medium text-red-700 mb-1">Pontos de atenção</p>
              <ul className="text-sm text-slate-600 space-y-0.5">
                {Object.entries(round.scoring.weaknesses).map(([k, v]) => (
                  <li key={k}>
                    {k}: {v}
                  </li>
                ))}
                {Object.keys(round.scoring.weaknesses).length === 0 && <li className="text-slate-400">-</li>}
              </ul>
            </div>
          </div>
        </div>
      )}

      {round.status === 'OPEN' && (
        <div className="card">
          <h2 className="font-semibold mb-3">Investir nesta rodada</h2>
          {error && <p className="text-red-600 text-sm mb-2">{error}</p>}
          {info && <p className="text-green-600 text-sm mb-2">{info}</p>}
          {(!user || user.role === 'INVESTOR') ? (
            <form onSubmit={invest} className="flex gap-3 items-end">
              <div className="flex-1">
                <label className="label">Montante (USD)</label>
                <input
                  className="input"
                  type="number"
                  min={round.minTicket}
                  step="0.01"
                  value={amount}
                  onChange={(e) => setAmount(e.target.value)}
                  required
                />
              </div>
              <button className="btn-primary" disabled={loading}>
                {loading ? 'A processar...' : 'Investir'}
              </button>
            </form>
          ) : (
            <p className="text-sm text-slate-500">Apenas contas de investidor podem investir.</p>
          )}
          {user?.role === 'INVESTOR' && (
            <button onClick={startConversation} className="btn-secondary mt-3">
              Contactar a startup
            </button>
          )}
        </div>
      )}
    </div>
  );
}
