import { Link } from 'react-router-dom';

export default function Landing() {
  return (
    <div>
      <section className="bg-gradient-to-b from-brand-700 to-brand-900 text-white">
        <div className="max-w-5xl mx-auto px-4 py-20 text-center">
          <h1 className="text-4xl font-bold mb-4">Invista em startups angolanas em fase seed</h1>
          <p className="text-brand-100 max-w-2xl mx-auto mb-8">
            A StartupInvest liga startups angolanas em fase de validação inicial a investidores, com avaliação
            estatística de potencial de crescimento e todo o processo de investimento - do pagamento à assinatura
            do contrato - feito na plataforma.
          </p>
          <div className="flex gap-3 justify-center">
            <Link to="/rounds" className="btn-primary bg-white text-brand-800 hover:bg-brand-50">
              Ver rodadas abertas
            </Link>
            <Link to="/register" className="btn-secondary bg-transparent border-white text-white hover:bg-white/10">
              Começar agora
            </Link>
          </div>
        </div>
      </section>
      <section className="max-w-5xl mx-auto px-4 py-14 grid sm:grid-cols-3 gap-6">
        <div className="card">
          <h3 className="font-semibold mb-1">Avaliação estatística</h3>
          <p className="text-sm text-slate-600">
            Cada rodada é avaliada num modelo estatístico ponderado - equipa, mercado, tração, financeiro e
            dificuldade de réplica - que estima a probabilidade de a startup chegar à Série B.
          </p>
        </div>
        <div className="card">
          <h3 className="font-semibold mb-1">Investimento seguro</h3>
          <p className="text-sm text-slate-600">
            Fundos ficam em regime de garantia até a meta ser atingida e o contrato assinado por ambas as partes,
            processados via PayPal.
          </p>
        </div>
        <div className="card">
          <h3 className="font-semibold mb-1">Contrato digital</h3>
          <p className="text-sm text-slate-600">
            Contrato de investimento ou mútuo conversível gerado automaticamente e assinado eletronicamente na
            plataforma.
          </p>
        </div>
      </section>
    </div>
  );
}
