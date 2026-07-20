import React, { useEffect, useRef, useState } from 'react';

export default function HeaderStatus({
    code,
    initialNotifications = 0,
    initialUnreadMessages = 0,
    profileUrl,
    profileLabel,
    settingsUrl,
    logoutUrl,
    avatarUrl,
    notificationsUrl,
    messagesUrl
}) {
    const [notifications, setNotifications] = useState(initialNotifications);
    const [unreadMessages, setUnreadMessages] = useState(initialUnreadMessages);
    const [menuOpen, setMenuOpen] = useState(false);
    const menuRef = useRef(null);

    useEffect(() => {
        if (!window.Echo) return undefined;

        const channel = window.Echo.private(`users.${code}`);

        channel.notification((notification) => {
            if (notification.type === 'App\\Notifications\\Notificao') {
                setNotifications(notification.qtdNotification || 0);
            } else if (notification.type === 'App\\Notifications\\Message') {
                setUnreadMessages(notification.qtdUnviewMessage || 0);
            }
        });

        return () => {
            window.Echo.leave(`users.${code}`);
        };
    }, [code]);

    useEffect(() => {
        function handleClickOutside(event) {
            if (menuRef.current && !menuRef.current.contains(event.target)) {
                setMenuOpen(false);
            }
        }
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    return (
        <div className="header-status">
            <a href={notificationsUrl} className="header-status__icon" aria-label="Notificações">
                <i className="fa fa-bell"></i>
                {notifications > 0 && (
                    <span className="header-status__badge">{notifications}</span>
                )}
            </a>

            <a href={messagesUrl} className="header-status__icon" aria-label="Mensagens">
                <i className="fa fa-envelope"></i>
                {unreadMessages > 0 && (
                    <span className="header-status__badge header-status__badge--dot"></span>
                )}
            </a>

            <div className="header-status__profile" ref={menuRef}>
                <button
                    type="button"
                    className="header-status__avatar-btn"
                    onClick={() => setMenuOpen((open) => !open)}
                >
                    <img src={avatarUrl} alt="" className="header-status__avatar" />
                </button>

                {menuOpen && (
                    <ul className="header-status__menu">
                        <li><a href={profileUrl}>Perfil {profileLabel}</a></li>
                        <li><a href={settingsUrl}>Configurações</a></li>
                        <li><a href={logoutUrl}>Sair</a></li>
                    </ul>
                )}
            </div>
        </div>
    );
}
