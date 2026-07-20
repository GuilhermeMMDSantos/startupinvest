import './bootstrap';

import React from 'react';
import { createRoot } from 'react-dom/client';
import components from './components';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-react-component]').forEach((node) => {
        const Component = components[node.dataset.reactComponent];
        if (!Component) return;

        const props = node.dataset.reactProps ? JSON.parse(node.dataset.reactProps) : {};
        createRoot(node).render(<Component {...props} />);
    });
});
