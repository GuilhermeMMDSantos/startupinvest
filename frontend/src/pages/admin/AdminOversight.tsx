import { useEffect, useState } from 'react';
import { api } from '../../lib/api';
import type { RoundDto, InvestmentDto, PaymentDto, ContractDto } from '../../types';

type Tab = 'rounds' | 'investments' | 'payments' | 'contracts';

export default function AdminOversight() {
  const [tab, setTab] = useState<Tab>('rounds');
  const [rounds, setRounds] = useState<RoundDto[]>([]);
  const [investments, setInvestments] = useState<InvestmentDto[]>([]);
  const [payments, setPayments] = useState<PaymentDto[]>([]);
  const [contracts, setContracts] = useState<ContractDto[]>([]);

  useEffect(() => {
    if (tab === 'rounds') api.get('/admin/rounds').then(({ data }) => setRounds(data));
    if (tab === 'investments') api.get('/admin/investments').then(({ data }) => setInvestments(data));
    if (tab === 'payments') api.get('/admin/payments').then(({ data }) => setPayments(data));
    if (tab === 'contracts') api.get('/admin/contracts').then(({ data }) => setContracts(data));
  }, [tab]);

  return (
    <div className="max-w-5xl mx-auto px-4 py-10 space-y-4">
      <h1 className="text-2xl font-bold">Supervisão da plataforma</h1>
      <div className="flex gap-2">
        {(['rounds', 'investments', 'payments', 'contracts'] as Tab[]).map((t) => (
          <button key={t} onClick={() => setTab(t)} className={tab === t ? 'btn-primary py-1' : 'btn-secondary py-1'}>
            {{ rounds: 'Rodadas', investments: 'Investimentos', payments: 'Pagamentos', contracts: 'Contratos' }[t]}
          </button>
        ))}
      </div>

      {tab === 'rounds' && (
        <div className="overflow-x-auto">
          <table className="w-full text-sm bg-white rounded-lg border border-slate-200">
            <thead className="bg-slate-50 text-left">
              <tr>
                <th className="p-2">Startup</th>
                <th className="p-2">Meta</th>
                <th className="p-2">Angariado</th>
                <th className="p-2">Estado</th>
              </tr>
            </thead>
            <tbody>
              {rounds.map((r) => (
                <tr key={r.id} className="border-t border-slate-100">
                  <td className="p-2">{r.startupName}</td>
                  <td className="p-2">{r.targetAmount.toLocaleString()} USD</td>
                  <td className="p-2">{r.amountRaised.toLocaleString()} USD</td>
                  <td className="p-2">{r.status}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {tab === 'investments' && (
        <div className="overflow-x-auto">
          <table className="w-full text-sm bg-white rounded-lg border border-slate-200">
            <thead className="bg-slate-50 text-left">
              <tr>
                <th className="p-2">Investidor</th>
                <th className="p-2">Startup</th>
                <th className="p-2">Valor</th>
                <th className="p-2">%</th>
                <th className="p-2">Estado</th>
              </tr>
            </thead>
            <tbody>
              {investments.map((i) => (
                <tr key={i.id} className="border-t border-slate-100">
                  <td className="p-2">{i.investorName}</td>
                  <td className="p-2">{i.startupName}</td>
                  <td className="p-2">{i.amount.toLocaleString()} USD</td>
                  <td className="p-2">{i.equityPctAllocated}%</td>
                  <td className="p-2">{i.status}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {tab === 'payments' && (
        <div className="overflow-x-auto">
          <table className="w-full text-sm bg-white rounded-lg border border-slate-200">
            <thead className="bg-slate-50 text-left">
              <tr>
                <th className="p-2">Tipo</th>
                <th className="p-2">Valor</th>
                <th className="p-2">Fornecedor</th>
                <th className="p-2">Estado</th>
                <th className="p-2">Data</th>
              </tr>
            </thead>
            <tbody>
              {payments.map((p) => (
                <tr key={p.id} className="border-t border-slate-100">
                  <td className="p-2">{p.type}</td>
                  <td className="p-2">
                    {p.amount.toLocaleString()} {p.currency}
                  </td>
                  <td className="p-2">{p.provider}</td>
                  <td className="p-2">{p.status}</td>
                  <td className="p-2">{new Date(p.createdAt).toLocaleString()}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {tab === 'contracts' && (
        <div className="overflow-x-auto">
          <table className="w-full text-sm bg-white rounded-lg border border-slate-200">
            <thead className="bg-slate-50 text-left">
              <tr>
                <th className="p-2">Investimento</th>
                <th className="p-2">Tipo</th>
                <th className="p-2">Estado</th>
              </tr>
            </thead>
            <tbody>
              {contracts.map((c) => (
                <tr key={c.id} className="border-t border-slate-100">
                  <td className="p-2">#{c.investmentId}</td>
                  <td className="p-2">{c.contractType}</td>
                  <td className="p-2">{c.status}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
}
