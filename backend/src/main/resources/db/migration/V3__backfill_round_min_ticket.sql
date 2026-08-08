UPDATE funding_rounds
SET min_ticket = TRUNC(target_amount / max_investors::numeric, 2);