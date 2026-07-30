import { useEffect, useState } from 'react';
import { api } from '../lib/api';
import type { NotificationDto } from '../types';

export default function Notifications() {
  const [items, setItems] = useState<NotificationDto[]>([]);

  function load() {
    api.get('/notifications').then(({ data }) => setItems(data));
  }

  useEffect(load, []);

  async function markRead(id: number) {
    await api.post(`/notifications/${id}/read`);
    load();
  }

  return (
    <div className="max-w-2xl mx-auto px-4 py-10">
      <h1 className="text-2xl font-bold mb-6">Notificações</h1>
      <div className="space-y-2">
        {items.length === 0 && <p className="text-sm text-slate-500">Sem notificações.</p>}
        {items.map((n) => (
          <div key={n.id} className={`card ${!n.readAt ? 'border-brand-400' : ''}`} onClick={() => !n.readAt && markRead(n.id)}>
            <div className="flex justify-between items-start">
              <p className="font-medium">{n.title}</p>
              {!n.readAt && <span className="badge bg-brand-100 text-brand-800">Novo</span>}
            </div>
            {n.body && <p className="text-sm text-slate-600 mt-1">{n.body}</p>}
            <p className="text-xs text-slate-400 mt-1">{new Date(n.createdAt).toLocaleString()}</p>
          </div>
        ))}
      </div>
    </div>
  );
}
