-- StartupInvest core schema
-- Equity crowdfunding platform for Angolan seed-stage startups

CREATE TABLE users (
    id              BIGSERIAL PRIMARY KEY,
    email           VARCHAR(180) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    role            VARCHAR(20)  NOT NULL CHECK (role IN ('ADMIN', 'INVESTOR', 'STARTUP_OWNER')),
    status          VARCHAR(30)  NOT NULL DEFAULT 'PENDING_VERIFICATION'
                        CHECK (status IN ('PENDING_VERIFICATION', 'ACTIVE', 'SUSPENDED', 'REJECTED')),
    created_at      TIMESTAMP NOT NULL DEFAULT now(),
    updated_at      TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TABLE investor_profiles (
    id                          BIGSERIAL PRIMARY KEY,
    user_id                     BIGINT NOT NULL UNIQUE REFERENCES users(id) ON DELETE CASCADE,
    full_name                   VARCHAR(180) NOT NULL,
    document_type               VARCHAR(20) NOT NULL CHECK (document_type IN ('BI', 'PASSPORT')),
    document_number             VARCHAR(60) NOT NULL,
    document_file_path          VARCHAR(500) NOT NULL,
    verification_video_path     VARCHAR(500) NOT NULL,
    phone                       VARCHAR(40),
    verification_status         VARCHAR(20) NOT NULL DEFAULT 'PENDING'
                                    CHECK (verification_status IN ('PENDING', 'APPROVED', 'REJECTED')),
    verification_notes          TEXT,
    verified_at                 TIMESTAMP,
    verified_by                 BIGINT REFERENCES users(id),
    created_at                  TIMESTAMP NOT NULL DEFAULT now(),
    updated_at                  TIMESTAMP NOT NULL DEFAULT now()
);
CREATE UNIQUE INDEX ux_investor_document ON investor_profiles (document_type, document_number);

CREATE TABLE startups (
    id                  BIGSERIAL PRIMARY KEY,
    owner_user_id       BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name                VARCHAR(180) NOT NULL,
    nif                 VARCHAR(40) NOT NULL UNIQUE,
    sector              VARCHAR(120),
    business_model      VARCHAR(20) CHECK (business_model IN ('B2C', 'B2B', 'B2B2C')),
    short_description   TEXT,
    website             VARCHAR(255),
    founded_at          DATE,
    pitch_deck_path     VARCHAR(500) NOT NULL,
    logo_path           VARCHAR(500),
    paypal_payout_email VARCHAR(180),
    status              VARCHAR(30) NOT NULL DEFAULT 'PENDING_APPROVAL'
                            CHECK (status IN ('PENDING_APPROVAL', 'APPROVED', 'REJECTED', 'SUSPENDED')),
    approved_at         TIMESTAMP,
    approved_by         BIGINT REFERENCES users(id),
    created_at          TIMESTAMP NOT NULL DEFAULT now(),
    updated_at          TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TABLE startup_team_members (
    id                  BIGSERIAL PRIMARY KEY,
    startup_id          BIGINT NOT NULL REFERENCES startups(id) ON DELETE CASCADE,
    full_name           VARCHAR(180) NOT NULL,
    role_title          VARCHAR(120) NOT NULL,
    experience_years    NUMERIC(5,2) NOT NULL DEFAULT 0,
    is_management       BOOLEAN NOT NULL DEFAULT false,
    is_technical        BOOLEAN NOT NULL DEFAULT false,
    linkedin_url        VARCHAR(255),
    created_at          TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TABLE funding_rounds (
    id                  BIGSERIAL PRIMARY KEY,
    startup_id          BIGINT NOT NULL REFERENCES startups(id) ON DELETE CASCADE,
    target_amount       NUMERIC(18,2) NOT NULL CHECK (target_amount > 0),
    equity_offered_pct  NUMERIC(5,2)  NOT NULL CHECK (equity_offered_pct > 0 AND equity_offered_pct <= 100),
    max_investors       INT NOT NULL CHECK (max_investors >= 2),
    min_ticket          NUMERIC(18,2) NOT NULL CHECK (min_ticket > 0),
    amount_raised       NUMERIC(18,2) NOT NULL DEFAULT 0,
    contract_type       VARCHAR(30) NOT NULL DEFAULT 'EQUITY_INVESTMENT'
                            CHECK (contract_type IN ('EQUITY_INVESTMENT', 'CONVERTIBLE_NOTE')),
    pitch_video_path    VARCHAR(500) NOT NULL,
    status              VARCHAR(30) NOT NULL DEFAULT 'DRAFT'
                            CHECK (status IN ('DRAFT', 'OPEN', 'FUNDED', 'CONTRACTS_PENDING', 'CLOSED_SUCCESS', 'CLOSED_CANCELLED')),
    opened_at           TIMESTAMP,
    closed_at           TIMESTAMP,
    created_at          TIMESTAMP NOT NULL DEFAULT now(),
    updated_at          TIMESTAMP NOT NULL DEFAULT now()
);
CREATE INDEX ix_funding_rounds_status ON funding_rounds(status);

CREATE TABLE startup_assessments (
    id                                      BIGSERIAL PRIMARY KEY,
    round_id                                BIGINT NOT NULL UNIQUE REFERENCES funding_rounds(id) ON DELETE CASCADE,
    market_growth_rate                      NUMERIC(10,2) DEFAULT 0,
    competitors_market_share                NUMERIC(10,2) DEFAULT 0,
    direct_competitors_count                NUMERIC(10,2) DEFAULT 0,
    target_market_size                      NUMERIC(18,2) DEFAULT 0,
    inflation_rate                          NUMERIC(10,2) DEFAULT 0,
    interest_rate                           NUMERIC(10,2) DEFAULT 0,
    unemployment_rate                       NUMERIC(10,2) DEFAULT 0,
    customer_retention_rate                 NUMERIC(10,2) DEFAULT 0,
    customer_base_growth                    NUMERIC(10,2) DEFAULT 0,
    initial_adoption_rate                   NUMERIC(10,2) DEFAULT 0,
    purchase_recurrence                     NUMERIC(10,2) DEFAULT 0,
    ltv                                     NUMERIC(18,2) DEFAULT 0,
    cac                                     NUMERIC(18,2) DEFAULT 0,
    avg_ticket                              NUMERIC(18,2) DEFAULT 0,
    revenue_growth_rate                     NUMERIC(10,2) DEFAULT 0,
    roi                                     NUMERIC(10,2) DEFAULT 0,
    gross_margin                            NUMERIC(10,2) DEFAULT 0,
    net_margin                              NUMERIC(10,2) DEFAULT 0,
    receivable_days                         NUMERIC(10,2) DEFAULT 0,
    revenue_sources_count                   NUMERIC(5,2) DEFAULT 0,
    revenue_product                         BOOLEAN DEFAULT false,
    revenue_subscription                    BOOLEAN DEFAULT false,
    revenue_advertising                     BOOLEAN DEFAULT false,
    revenue_other                           BOOLEAN DEFAULT false,
    avg_experience_years                    NUMERIC(6,2) DEFAULT 0,
    team_size                               NUMERIC(5,2) DEFAULT 0,
    management_exp_count                    NUMERIC(5,2) DEFAULT 0,
    technical_count                         NUMERIC(5,2) DEFAULT 0,
    weekly_work_hours                       NUMERIC(6,2) DEFAULT 0,
    time_working_together_years             NUMERIC(6,2) DEFAULT 0,
    has_intellectual_property               BOOLEAN DEFAULT false,
    has_exclusive_technology                BOOLEAN DEFAULT false,
    has_exclusive_distribution_channels     BOOLEAN DEFAULT false,
    automation_level                        NUMERIC(10,2) DEFAULT 0,
    participated_incubation                 BOOLEAN DEFAULT false,
    previous_funding_rounds                 NUMERIC(5,2) DEFAULT 0,
    business_model_type                     VARCHAR(20) CHECK (business_model_type IN ('B2C', 'B2B', 'B2B2C')),
    created_at                              TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TABLE scoring_results (
    id                      BIGSERIAL PRIMARY KEY,
    assessment_id           BIGINT NOT NULL UNIQUE REFERENCES startup_assessments(id) ON DELETE CASCADE,
    growth_potential_score  NUMERIC(5,2) NOT NULL,
    series_b_likelihood     VARCHAR(20) NOT NULL CHECK (series_b_likelihood IN ('BAIXO', 'MEDIO', 'ALTO')),
    strengths               JSONB NOT NULL DEFAULT '{}',
    weaknesses              JSONB NOT NULL DEFAULT '{}',
    computed_at             TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TABLE investments (
    id                      BIGSERIAL PRIMARY KEY,
    round_id                BIGINT NOT NULL REFERENCES funding_rounds(id),
    investor_id             BIGINT NOT NULL REFERENCES investor_profiles(id),
    amount                  NUMERIC(18,2) NOT NULL CHECK (amount > 0),
    equity_pct_allocated    NUMERIC(8,4) NOT NULL,
    status                  VARCHAR(30) NOT NULL DEFAULT 'PENDING_PAYMENT'
                                CHECK (status IN ('PENDING_PAYMENT', 'PAID', 'CONTRACT_PENDING', 'CONTRACT_SIGNED', 'CONFIRMED', 'CANCELLED', 'REFUNDED')),
    created_at              TIMESTAMP NOT NULL DEFAULT now(),
    updated_at              TIMESTAMP NOT NULL DEFAULT now()
);
CREATE INDEX ix_investments_round ON investments(round_id);
CREATE INDEX ix_investments_investor ON investments(investor_id);

CREATE TABLE payments (
    id                  BIGSERIAL PRIMARY KEY,
    investment_id       BIGINT REFERENCES investments(id),
    payout_id           BIGINT,
    type                VARCHAR(20) NOT NULL CHECK (type IN ('DEPOSIT', 'PAYOUT')),
    provider             VARCHAR(20) NOT NULL DEFAULT 'PAYPAL',
    provider_order_id   VARCHAR(120),
    amount              NUMERIC(18,2) NOT NULL,
    currency            VARCHAR(10) NOT NULL DEFAULT 'USD',
    status              VARCHAR(20) NOT NULL CHECK (status IN ('CREATED', 'APPROVED', 'COMPLETED', 'FAILED', 'CANCELLED')),
    raw_response        TEXT,
    created_at          TIMESTAMP NOT NULL DEFAULT now(),
    updated_at          TIMESTAMP NOT NULL DEFAULT now()
);
CREATE INDEX ix_payments_investment ON payments(investment_id);

CREATE TABLE payouts (
    id                          BIGSERIAL PRIMARY KEY,
    round_id                    BIGINT NOT NULL UNIQUE REFERENCES funding_rounds(id),
    provider_payout_batch_id    VARCHAR(120),
    amount                      NUMERIC(18,2) NOT NULL,
    status                      VARCHAR(20) NOT NULL DEFAULT 'PENDING'
                                    CHECK (status IN ('PENDING', 'PROCESSING', 'COMPLETED', 'FAILED')),
    created_at                  TIMESTAMP NOT NULL DEFAULT now(),
    updated_at                  TIMESTAMP NOT NULL DEFAULT now()
);

ALTER TABLE payments ADD CONSTRAINT fk_payments_payout FOREIGN KEY (payout_id) REFERENCES payouts(id);

CREATE TABLE contracts (
    id                  BIGSERIAL PRIMARY KEY,
    investment_id       BIGINT NOT NULL UNIQUE REFERENCES investments(id),
    contract_type       VARCHAR(30) NOT NULL CHECK (contract_type IN ('EQUITY_INVESTMENT', 'CONVERTIBLE_NOTE')),
    content             TEXT NOT NULL,
    status              VARCHAR(20) NOT NULL DEFAULT 'PENDING'
                            CHECK (status IN ('PENDING', 'STARTUP_SIGNED', 'INVESTOR_SIGNED', 'FULLY_SIGNED', 'VOID')),
    created_at          TIMESTAMP NOT NULL DEFAULT now(),
    updated_at          TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TABLE contract_signatures (
    id                  BIGSERIAL PRIMARY KEY,
    contract_id         BIGINT NOT NULL REFERENCES contracts(id) ON DELETE CASCADE,
    signer_user_id       BIGINT NOT NULL REFERENCES users(id),
    signer_role         VARCHAR(20) NOT NULL CHECK (signer_role IN ('STARTUP', 'INVESTOR')),
    full_name_typed     VARCHAR(180) NOT NULL,
    signature_hash      VARCHAR(128) NOT NULL,
    signed_at           TIMESTAMP NOT NULL DEFAULT now(),
    ip_address          VARCHAR(64)
);
CREATE UNIQUE INDEX ux_contract_signature ON contract_signatures(contract_id, signer_role);

CREATE TABLE conversations (
    id                  BIGSERIAL PRIMARY KEY,
    round_id            BIGINT NOT NULL REFERENCES funding_rounds(id),
    startup_id          BIGINT NOT NULL REFERENCES startups(id),
    investor_id         BIGINT NOT NULL REFERENCES investor_profiles(id),
    created_at          TIMESTAMP NOT NULL DEFAULT now(),
    UNIQUE(round_id, investor_id)
);

CREATE TABLE messages (
    id                  BIGSERIAL PRIMARY KEY,
    conversation_id     BIGINT NOT NULL REFERENCES conversations(id) ON DELETE CASCADE,
    sender_user_id      BIGINT NOT NULL REFERENCES users(id),
    content             TEXT NOT NULL,
    sent_at             TIMESTAMP NOT NULL DEFAULT now(),
    read_at             TIMESTAMP
);
CREATE INDEX ix_messages_conversation ON messages(conversation_id);

CREATE TABLE notifications (
    id                  BIGSERIAL PRIMARY KEY,
    user_id             BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    type                VARCHAR(60) NOT NULL,
    title               VARCHAR(180) NOT NULL,
    body                TEXT,
    read_at             TIMESTAMP,
    created_at          TIMESTAMP NOT NULL DEFAULT now()
);
CREATE INDEX ix_notifications_user ON notifications(user_id);
