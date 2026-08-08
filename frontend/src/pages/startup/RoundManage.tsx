import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import { api, apiErrorMessage, fileUrl } from '../../lib/api';
import type { RoundDto, InvestmentDto } from '../../types';
import ScoringBadge from '../../components/ScoringBadge';

export default function RoundManage() {
  const { roundId } = useParams();
  const [round, setRound] = useState<RoundDto | null>(null);
  const [investments, setInvestments] = useState<InvestmentDto[]>([]);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  function load() {
    api.get(`/rounds/${roundId}/owner`).then(({ data }) => setRound(data));
    api.get(`/rounds/${roundId}/investments`).then(({ data }) => setInvestments(data)).catch(() => {});
  }

  useEffect(load, [roundId]);

  async function openRound() {
    setError(null);
    setLoading(true);
    try {
      await api.post(`/rounds/${roundId}/open`);
      load();
    } catch (err) {
      setError(apiErrorMessage(err));
    } finally {
      setLoading(false);
    }
  }

  async function cancelRound() {
    setError(null);
    setLoading(true);
    try {
      await api.post(`/rounds/${roundId}/cancel`);
      load();
    } catch (err) {
      setError(apiErrorMessage(err));
    } finally {
      setLoading(false);
    }
  }

  if (!round) return <div className="max-w-3xl mx-auto px-4 py-10">A carregar...</div>;

  const pct = Math.min(100, (round.amountRaised / round.targetAmount) * 100);

  return (
    <div className="max-w-3xl mx-auto px-4 py-10 space-y-6">
      <h1 className="text-2xl font-bold">Rodada #{round.id}</h1>
      {error && <p className="text-red-600 text-sm">{error}</p>}

      <div className="card space-y-3">
        <div className="w-full bg-slate-100 rounded-full h-3">
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
            <p className="text-slate-500">Mínimo</p>
            <p className="font-semibold">{round.minTicket.toLocaleString()} USD</p>
          </div>
          <div>
            <p className="text-slate-500">Estado</p>
            <p className="font-semibold">{round.status}</p>
          </div>
        </div>
        <video controls className="w-full rounded-md" src={fileUrl(round.pitchVideoPath)} />

        {round.scoring && (
          <div>
            <ScoringBadge likelihood={round.scoring.seriesBLikelihood} score={round.scoring.growthPotentialScore} />
          </div>
        )}

        <div className="flex gap-2 pt-2">
          {round.status === 'DRAFT' && !round.scoring && (
            <Link to={`/startup/rounds/${round.id}/assessment`} className="btn-primary">
              Submeter avaliação
            </Link>
          )}
          {round.status === 'DRAFT' && round.scoring && (
            <button className="btn-primary" onClick={openRound} disabled={loading}>
              Abrir rodada a investidores
            </button>
          )}
          {(round.status === 'DRAFT' || round.status === 'OPEN') && (
            <button className="btn-danger" onClick={cancelRound} disabled={loading}>
              Cancelar rodada
            </button>
          )}
        </div>
      </div>

      <div>
        <h2 className="font-semibold mb-3">Investidores</h2>
        <div className="space-y-2">
          {investments.length === 0 && <p className="text-sm text-slate-500">Ainda sem investimentos.</p>}
          {investments.map((inv) => (
            <Link
              key={inv.id}
              to={`/startup/rounds/${round.id}/investments/${inv.id}`}
              className="card flex justify-between items-center hover:border-brand-400"
            >
              <div>
                <p className="font-medium">{inv.investorName}</p>
                <p className="text-xs text-slate-500">
                  {inv.amount.toLocaleString()} USD · {inv.equityPctAllocated}%
                </p>
              </div>
              <span className="badge bg-slate-100 text-slate-700">{inv.status}</span>
            </Link>
          ))}
        </div>
      </div>
    </div>
  );
}
