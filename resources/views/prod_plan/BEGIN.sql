BEGIN
        IF p_action = 'INSERT' THEN
    INSERT INTO production_plans(
        group_id,
        season_id,
        planned_area_ha,
        planned_yield_tons,
        planned_inputs_cost,
        status,
        created_by,
        created_at
    )
VALUES(
    p_group_id,
    p_season_id,
    p_area,
    p_yield,
    p_cost,
    'DRAFT',
    p_user_id,
    NOW()
) ;

ELSEIF p_action = 'UPDATE' THEN
UPDATE
    production_plans
SET
    planned_area_ha = p_area,
    planned_yield_tons = p_yield,
    planned_inputs_cost = p_cost,
    status= p_status,
    approved_by_manager = IF(
        p_status IN('APPROVED', 'REJECTED'),
        p_user_id,
        approved_by_manager
    ),
    approval_date = IF(
        p_status IN('APPROVED', 'REJECTED'),
        NOW(), approval_date),
    updated_by = p_user_id,
    updated_at = NOW()
    WHERE
        plan_id = p_plan_id ;

ELSEIF p_action = 'DELETE' THEN
    DELETE FROM production_plans WHERE plan_id = p_plan_id ;
END IF ;

END
