import { Link } from 'react-router-dom';
import type { RoundDto } from '../types';
import ScoringBadge from './ScoringBadge';

export default function RoundCard({ round }: { round: RoundDto }) {
  const pct = Math.min(100, (round.amountRaised / round.targetAmount) * 100);
  return (
    <Link to={`/rounds/${round.id}`} className="card block hover:border-brand-400 transition-colors">
      <div className="flex items-start justify-between mb-2">
        <div>
          <h3 className="font-semibold">{round.startupName}</h3>
          <p className="text-xs text-slate-500">{round.startupSector ?? 'Sector não indicado'}</p>
        </div>
        {round.scoring && <ScoringBadge likelihood={round.scoring.seriesBLikelihood} score={round.scoring.growthPotentialScore} />}
      </div>
      <div className="w-full bg-slate-100 rounded-full h-2 mb-2">
        <div className="bg-brand-600 h-2 rounded-full" style={{ width: `${pct}%` }} />
      </div>
      <div className="flex justify-between text-sm text-slate-600">
        <span>{round.amountRaised.toLocaleString()} USD angariados</span>
        <span>Meta: {round.targetAmount.toLocaleString()} USD</span>
      </div>
      <div className="flex justify-between text-xs text-slate-500 mt-1">
        <span>Mínimo: {round.minTicket.toLocaleString()} USD</span>
        <span>Capital oferecido: {round.equityOfferedPct}%</span>
      </div>
    </Link>
  );
}
