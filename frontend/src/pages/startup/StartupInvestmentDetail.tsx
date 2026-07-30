import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { api } from '../../lib/api';
import type { InvestmentDto } from '../../types';
import ContractPanel from '../../components/ContractPanel';

export default function StartupInvestmentDetail() {
  const { investmentId } = useParams();
  const [investment, setInvestment] = useState<InvestmentDto | null>(null);

  useEffect(() => {
    api.get(`/investments/${investmentId}`).then(({ data }) => setInvestment(data)).catch(() => setInvestment(null));
  }, [investmentId]);

  if (!investment) return <div className="max-w-3xl mx-auto px-4 py-10">A carregar...</div>;

  return (
    <div className="max-w-3xl mx-auto px-4 py-10 space-y-6">
      <div>
        <h1 className="text-2xl font-bold">Investimento de {investment.investorName}</h1>
        <p className="text-slate-500">
          {investment.amount.toLocaleString()} USD · {investment.equityPctAllocated}% do capital social
        </p>
      </div>
      <div className="card">
        <ContractPanel investmentId={investment.id} role="STARTUP" />
      </div>
    </div>
  );
}
