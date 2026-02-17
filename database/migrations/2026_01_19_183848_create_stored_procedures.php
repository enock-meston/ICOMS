<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop procedures if they exist
        $this->down();

        // Stored Procedure: sp_members
        // Handles INSERT, UPDATE, DELETE operations for members table
        DB::unprepared("
            CREATE PROCEDURE sp_members(
                IN p_action VARCHAR(10),
                IN p_id INT,
                IN p_member_code VARCHAR(50),
                IN p_names VARCHAR(255),
                IN p_phone VARCHAR(20),
                IN p_gender VARCHAR(10),
                IN p_group_id INT,
                IN p_national_ID VARCHAR(50),
                IN p_joinDate DATE,
                IN p_Shares VARCHAR(50),
                IN p_status VARCHAR(50)
            )
            BEGIN
                DECLARE v_member_code VARCHAR(50);
                
                IF p_action = 'INSERT' THEN
                    -- Generate member code automatically
                    SELECT CONCAT('MEM', LPAD(COALESCE(MAX(CAST(SUBSTRING(member_code, 4) AS UNSIGNED)), 0) + 1, 6, '0'))
                    INTO v_member_code
                    FROM members;
                    
                    INSERT INTO members (
                        member_code, names, phone, gender, group_id, 
                        national_ID, joinDate, Shares, status, created_at, updated_at
                    ) VALUES (
                        v_member_code, p_names, p_phone, p_gender, p_group_id,
                        p_national_ID, p_joinDate, p_Shares, p_status, NOW(), NOW()
                    );
                    
                ELSEIF p_action = 'UPDATE' THEN
                    UPDATE members SET
                        names = p_names,
                        phone = p_phone,
                        gender = p_gender,
                        group_id = p_group_id,
                        national_ID = p_national_ID,
                        joinDate = p_joinDate,
                        Shares = p_Shares,
                        status = p_status,
                        updated_at = NOW()
                    WHERE id = p_id;
                    
                ELSEIF p_action = 'DELETE' THEN
                    DELETE FROM members WHERE id = p_id;
                END IF;
            END
        ");

        // Stored Procedure: sp_input_allocations
        // Handles INSERT, UPDATE, DELETE operations for input__allocations table
        DB::unprepared("
            CREATE PROCEDURE sp_input_allocations(
                IN p_action VARCHAR(10),
                IN p_id INT,
                IN p_member_id INT,
                IN p_season_id INT,
                IN p_Type VARCHAR(255),
                IN p_Quantity VARCHAR(255),
                IN p_Unit_Cost VARCHAR(255),
                IN p_approved_by_manager INT,
                IN p_Approval_Date DATE,
                IN p_Status VARCHAR(50)
            )
            BEGIN
                DECLARE v_total_value DECIMAL(12, 2);
                
                IF p_action = 'INSERT' THEN
                    SET v_total_value = CAST(p_Quantity AS DECIMAL(12, 2)) * CAST(p_Unit_Cost AS DECIMAL(12, 2));
                    
                    INSERT INTO input__allocations (
                        member_id, season_id, Type_, Quantity, Unit_Cost, 
                        Total_Value, Issue_Date, approved_by_manager, 
                        Approval_Date, Status, created_at, updated_at
                    ) VALUES (
                        p_member_id, p_season_id, p_Type, p_Quantity, p_Unit_Cost,
                        v_total_value, CURDATE(), p_approved_by_manager,
                        p_Approval_Date, p_Status, NOW(), NOW()
                    );
                    
                ELSEIF p_action = 'UPDATE' THEN
                    SET v_total_value = CAST(p_Quantity AS DECIMAL(12, 2)) * CAST(p_Unit_Cost AS DECIMAL(12, 2));
                    
                    UPDATE input__allocations SET
                        member_id = p_member_id,
                        season_id = p_season_id,
                        Type_ = p_Type,
                        Quantity = p_Quantity,
                        Unit_Cost = p_Unit_Cost,
                        Total_Value = v_total_value,
                        approved_by_manager = p_approved_by_manager,
                        Approval_Date = p_Approval_Date,
                        Status = p_Status,
                        updated_at = NOW()
                    WHERE id = p_id;
                    
                ELSEIF p_action = 'DELETE' THEN
                    DELETE FROM input__allocations WHERE id = p_id;
                END IF;
            END
        ");

        // Stored Procedure: sp_plan_save
        // Handles INSERT, UPDATE, DELETE operations for production_plans table
        DB::unprepared("
            CREATE PROCEDURE sp_plan_save(
                IN p_action VARCHAR(10),
                IN p_plan_id INT,
                IN p_group_id INT,
                IN p_season_id INT,
                IN p_planned_area_ha DECIMAL(10, 2),
                IN p_planned_yield_tons DECIMAL(10, 2),
                IN p_planned_inputs_cost DECIMAL(12, 2),
                IN p_status VARCHAR(50),
                IN p_created_by INT
            )
            BEGIN
                IF p_action = 'INSERT' THEN
                    INSERT INTO production_plans (
                        group_id, season_id, planned_area_ha, planned_yield_tons,
                        planned_inputs_cost, status, created_by, created_at, updated_at
                    ) VALUES (
                        p_group_id, p_season_id, p_planned_area_ha, p_planned_yield_tons,
                        p_planned_inputs_cost, p_status, p_created_by, NOW(), NOW()
                    );
                    
                ELSEIF p_action = 'UPDATE' THEN
                    UPDATE production_plans SET
                        group_id = p_group_id,
                        season_id = p_season_id,
                        planned_area_ha = p_planned_area_ha,
                        planned_yield_tons = p_planned_yield_tons,
                        planned_inputs_cost = p_planned_inputs_cost,
                        status = p_status,
                        updated_at = NOW()
                    WHERE id = p_plan_id;
                    
                ELSEIF p_action = 'DELETE' THEN
                    DELETE FROM production_plans WHERE id = p_plan_id;
                END IF;
            END
        ");

        // Stored Procedure: sp_rice_deliveries_action
        // Handles INSERT, UPDATE, DELETE operations for rice__deliveries table
        DB::unprepared("
            CREATE PROCEDURE sp_rice_deliveries_action(
                IN p_action VARCHAR(10),
                IN p_id INT,
                IN p_member_id INT,
                IN p_season_id INT,
                IN p_Delivery_Date DATE,
                IN p_Quantity_KG VARCHAR(255),
                IN p_Quality_Grade VARCHAR(50),
                IN p_Unit_Price VARCHAR(255),
                IN p_Gross_Value VARCHAR(255),
                IN p_Loan_Deduction VARCHAR(255),
                IN p_Other_Deductions VARCHAR(255),
                IN p_Net_Payable VARCHAR(255),
                IN p_Created_By INT
            )
            BEGIN
                IF p_action = 'INSERT' THEN
                    INSERT INTO rice__deliveries (
                        member_id, season_id, Delivery_Date, Quantity_KG,
                        Quality_Grade, Unit_Price, Gross_Value, Loan_Deduction,
                        Other_Deductions, Net_Payable, Created_By, created_at, updated_at
                    ) VALUES (
                        p_member_id, p_season_id, p_Delivery_Date, p_Quantity_KG,
                        p_Quality_Grade, p_Unit_Price, p_Gross_Value, p_Loan_Deduction,
                        p_Other_Deductions, p_Net_Payable, p_Created_By, NOW(), NOW()
                    );
                    
                ELSEIF p_action = 'UPDATE' THEN
                    UPDATE rice__deliveries SET
                        member_id = p_member_id,
                        season_id = p_season_id,
                        Delivery_Date = p_Delivery_Date,
                        Quantity_KG = p_Quantity_KG,
                        Quality_Grade = p_Quality_Grade,
                        Unit_Price = p_Unit_Price,
                        Gross_Value = p_Gross_Value,
                        Loan_Deduction = p_Loan_Deduction,
                        Other_Deductions = p_Other_Deductions,
                        Net_Payable = p_Net_Payable,
                        updated_at = NOW()
                    WHERE id = p_id;
                    
                ELSEIF p_action = 'DELETE' THEN
                    DELETE FROM rice__deliveries WHERE id = p_id;
                END IF;
            END
        ");

        // Stored Procedure: sp_field_activities
        // Handles INSERT, UPDATE, DELETE operations for field_activities table
        DB::unprepared("
            CREATE PROCEDURE sp_field_activities(
                IN p_action VARCHAR(10),
                IN p_id INT,
                IN p_plan_id INT,
                IN p_activity_type VARCHAR(255),
                IN p_planned_date DATE,
                IN p_actual_date DATE,
                IN p_officer_user_id INT,
                IN p_status VARCHAR(50)
            )
            BEGIN
                IF p_action = 'INSERT' THEN
                    INSERT INTO field_activities (
                        plan_id, activity_type, planned_date, actual_date,
                        officer_user_id, status, created_at, updated_at
                    ) VALUES (
                        p_plan_id, p_activity_type, p_planned_date, p_actual_date,
                        p_officer_user_id, p_status, NOW(), NOW()
                    );
                    
                ELSEIF p_action = 'UPDATE' THEN
                    UPDATE field_activities SET
                        plan_id = p_plan_id,
                        activity_type = p_activity_type,
                        planned_date = p_planned_date,
                        actual_date = p_actual_date,
                        officer_user_id = p_officer_user_id,
                        status = p_status,
                        updated_at = NOW()
                    WHERE id = p_id;
                    
                ELSEIF p_action = 'DELETE' THEN
                    DELETE FROM field_activities WHERE id = p_id;
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_members');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_input_allocations');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_plan_save');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_rice_deliveries_action');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_field_activities');
    }
};
