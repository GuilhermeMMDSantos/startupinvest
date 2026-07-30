import { useEffect, useState } from 'react';
import { api, apiErrorMessage } from '../lib/api';
import type { ContractDto } from '../types';

const STATUS_LABEL: Record<string, string> = {
  PENDING: 'Aguarda assinaturas',
  STARTUP_SIGNED: 'Assinado pela startup',
  INVESTOR_SIGNED: 'Assinado pelo investidor',
  FULLY_SIGNED: 'Totalmente assinado',
  VOID: 'Anulado',
};

export default function ContractPanel({ investmentId, role }: { investmentId: number; role: 'INVESTOR' | 'STARTUP' }) {
  const [contract, setContract] = useState<ContractDto | null>(null);
  const [fullName, setFullName] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  function load() {
    api
      .get(`/investments/${investmentId}/contract`)
      .then(({ data }) => setContract(data))
      .catch(() => setContract(null));
  }

  useEffect(load, [investmentId]);

  if (!contract) {
    return <p className="text-sm text-slate-500">O contrato ainda será gerado após a confirmação do pagamento.</p>;
  }

  const alreadySignedByMe =
    (role === 'INVESTOR' && (contract.status === 'INVESTOR_SIGNED' || contract.status === 'FULLY_SIGNED')) ||
    (role === 'STARTUP' && (contract.status === 'STARTUP_SIGNED' || contract.status === 'FULLY_SIGNED'));

  async function sign() {
    setError(null);
    setLoading(true);
    try {
      await api.post(`/contracts/${contract!.id}/sign`, { fullNameTyped: fullName });
      load();
    } catch (err) {
      setError(apiErrorMessage(err));
    } finally {
      setLoading(false);
    }
  }

  return (
    <div>
      <div className="flex items-center justify-between mb-2">
        <h3 className="font-semibold">Contrato ({contract.contractType === 'CONVERTIBLE_NOTE' ? 'Mútuo conversível' : 'Investimento'})</h3>
        <span className="badge bg-slate-100 text-slate-700">{STATUS_LABEL[contract.status] ?? contract.status}</span>
      </div>
      <pre className="whitespace-pre-wrap text-xs bg-slate-50 border border-slate-200 rounded-md p-4 max-h-80 overflow-y-auto">
        {contract.content}
      </pre>
      {error && <p className="text-red-600 text-sm mt-2">{error}</p>}
      {!alreadySignedByMe && contract.status !== 'VOID' && (
        <div className="mt-3 flex gap-2 items-end">
          <div className="flex-1">
            <label className="label">Assine digitando o seu nome completo</label>
            <input className="input" value={fullName} onChange={(e) => setFullName(e.target.value)} />
          </div>
          <button className="btn-primary" onClick={sign} disabled={loading || !fullName}>
            {loading ? 'A assinar...' : 'Assinar contrato'}
          </button>
        </div>
      )}
      {alreadySignedByMe && contract.status !== 'FULLY_SIGNED' && (
        <p className="text-sm text-slate-500 mt-2">Já assinou. A aguardar a assinatura da outra parte.</p>
      )}
    </div>
  );
}
