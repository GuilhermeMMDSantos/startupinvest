import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { api } from '../../lib/api';
import type { InvestorProfileDto, InvestmentDto } from '../../types';

const VERIFICATION_LABEL: Record<string, string> = {
  PENDING: 'Pendente de verificação pelo administrador',
  APPROVED: 'Verificado',
  REJECTED: 'Verificação rejeitada',
};

export default function InvestorDashboard() {
  const [profile, setProfile] = useState<InvestorProfileDto | null>(null);
  const [investments, setInvestments] = useState<InvestmentDto[]>([]);

  useEffect(() => {
    api.get('/investors/me').then(({ data }) => setProfile(data));
    api.get('/investments/mine').then(({ data }) => setInvestments(data));
  }, []);

  return (
    <div className="max-w-4xl mx-auto px-4 py-10 space-y-6">
      <h1 className="text-2xl font-bold">Painel do Investidor</h1>

      {profile && (
        <div className="card">
          <p className="text-sm text-slate-500">Estado da verificação</p>
          <p className="font-semibold">{VERIFICATION_LABEL[profile.verificationStatus]}</p>
          {profile.verificationStatus !== 'APPROVED' && (
            <p className="text-sm text-slate-500 mt-1">
              Só poderá investir depois de a sua identidade ser verificada pelo administrador da plataforma.
            </p>
          )}
        </div>
      )}

      <div className="grid sm:grid-cols-3 gap-4">
        <Link to="/rounds" className="card hover:border-brand-400">
          <p className="font-semibold">Explorar rodadas</p>
          <p className="text-sm text-slate-500">Veja startups em captação</p>
        </Link>
        <Link to="/investor/messages" className="card hover:border-brand-400">
          <p className="font-semibold">Mensagens</p>
          <p className="text-sm text-slate-500">Converse com startups</p>
        </Link>
        <Link to="/notifications" className="card hover:border-brand-400">
          <p className="font-semibold">Notificações</p>
          <p className="text-sm text-slate-500">Atualizações da plataforma</p>
        </Link>
      </div>

      <div>
        <h2 className="font-semibold mb-3">Os meus investimentos</h2>
        <div className="space-y-2">
          {investments.length === 0 && <p className="text-sm text-slate-500">Ainda não fez nenhum investimento.</p>}
          {investments.map((inv) => (
            <Link key={inv.id} to={`/investor/investments/${inv.id}`} className="card flex justify-between items-center hover:border-brand-400">
              <div>
                <p className="font-medium">{inv.startupName}</p>
                <p className="text-xs text-slate-500">{inv.amount.toLocaleString()} USD · {inv.equityPctAllocated}%</p>
              </div>
              <span className="badge bg-slate-100 text-slate-700">{inv.status}</span>
            </Link>
          ))}
        </div>
      </div>
    </div>
  );
}
