import { useEffect, useState } from 'react';
import { useParams, useSearchParams } from 'react-router-dom';
import { api, apiErrorMessage } from '../../lib/api';
import type { InvestmentDto } from '../../types';
import ContractPanel from '../../components/ContractPanel';

const STATUS_LABEL: Record<string, string> = {
  PENDING_PAYMENT: 'Aguarda pagamento',
  PAID: 'Pago — contrato a ser gerado',
  CONTRACT_PENDING: 'Aguarda assinatura do contrato',
  CONTRACT_SIGNED: 'Assinado por si — aguarda a startup',
  CONFIRMED: 'Confirmado',
  CANCELLED: 'Cancelado',
  REFUNDED: 'Reembolsado',
};

export default function InvestmentDetail() {
  const { id } = useParams();
  const [searchParams, setSearchParams] = useSearchParams();
  const [investment, setInvestment] = useState<InvestmentDto | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  function load() {
    api.get(`/investments/${id}`).then(({ data }) => setInvestment(data));
  }

  useEffect(load, [id]);

  useEffect(() => {
    const orderId = searchParams.get('token');
    if (orderId && investment && investment.status === 'PENDING_PAYMENT') {
      setLoading(true);
      api
        .post(`/investments/${id}/payment/capture`, null, { params: { orderId } })
        .then(({ data }) => {
          setInvestment(data);
          searchParams.delete('token');
          searchParams.delete('PayerID');
          setSearchParams(searchParams, { replace: true });
        })
        .catch((err) => setError(apiErrorMessage(err)))
        .finally(() => setLoading(false));
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [investment?.id]);

  async function payWithPaypal() {
    setError(null);
    setLoading(true);
    try {
      const returnUrl = window.location.origin + `/investor/investments/${id}`;
      const { data } = await api.post(`/investments/${id}/payment/create`, { returnUrl, cancelUrl: returnUrl });
      window.location.href = data.approveUrl;
    } catch (err) {
      setError(apiErrorMessage(err));
      setLoading(false);
    }
  }

  if (!investment) return <div className="max-w-3xl mx-auto px-4 py-10">A carregar...</div>;

  return (
    <div className="max-w-3xl mx-auto px-4 py-10 space-y-6">
      <div>
        <h1 className="text-2xl font-bold">Investimento em {investment.startupName}</h1>
        <p className="text-slate-500">
          {investment.amount.toLocaleString()} USD · {investment.equityPctAllocated}% do capital social
        </p>
      </div>

      {error && <p className="text-red-600 text-sm">{error}</p>}

      <div className="card">
        <p className="text-sm text-slate-500 mb-1">Estado</p>
        <p className="font-semibold mb-3">{STATUS_LABEL[investment.status] ?? investment.status}</p>

        {investment.status === 'PENDING_PAYMENT' && (
          <button className="btn-primary" onClick={payWithPaypal} disabled={loading}>
            {loading ? 'A processar...' : 'Pagar com PayPal (sandbox)'}
          </button>
        )}
      </div>

      {['PAID', 'CONTRACT_PENDING', 'CONTRACT_SIGNED', 'CONFIRMED'].includes(investment.status) && (
        <div className="card">
          <ContractPanel investmentId={investment.id} role="INVESTOR" />
        </div>
      )}
    </div>
  );
}
