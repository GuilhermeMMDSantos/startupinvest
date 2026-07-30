const COLORS: Record<string, string> = {
  ALTO: 'bg-green-100 text-green-800',
  MEDIO: 'bg-amber-100 text-amber-800',
  BAIXO: 'bg-red-100 text-red-800',
};

const LABELS: Record<string, string> = {
  ALTO: 'Potencial alto',
  MEDIO: 'Potencial médio',
  BAIXO: 'Potencial baixo',
};

export default function ScoringBadge({ likelihood, score }: { likelihood: string; score: number }) {
  return (
    <span className={`badge ${COLORS[likelihood] ?? 'bg-slate-100 text-slate-700'}`}>
      {LABELS[likelihood] ?? likelihood} · {score.toFixed(0)}/100
    </span>
  );
}
