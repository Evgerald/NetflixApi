<?php

namespace App\Transformers\Import\Csv;

/**
 * User Transformer
 *
 * Transform specific fields from users.csv to correct array for upsert
 *
 * @version 1.0
 */
class UserTransformer extends AbstractCsvTransformer
{
    /**
     * @param array $row
     *
     * @return array
     */
    public static function transform(array $row): array
    {
        $row = array_map('trim', $row);

        // Age
        $row['age'] = is_numeric($row['age'] ?? null) ? (float) $row['age'] : null;

        // Gender
        $allowedGenders = ['Male', 'Female', 'Prefer not to say', 'Other'];
        $gender = ucfirst(strtolower($row['gender'] ?? ''));
        $row['gender'] = in_array($gender, $allowedGenders, true) ? $gender : null;

        // Subscription plans
        $subscriptionPlans = ['Standard', 'Premium', 'Basic', 'Premium+'];
        $plan = trim($row['subscription_plan'] ?? '');
        $row['subscription_plan'] = in_array($plan, $subscriptionPlans, true) ? $plan : 'Standard';

        // Subscription start date -> date (YYYY-mm-dd)
        $date = $row['subscription_start_date'] ?? null;
        $row['subscription_start_date'] = self::normalizeDate($date);

        // Is active
        $row['is_active'] = filter_var($row['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        // Monthly spend
        $row['monthly_spend'] = is_numeric($row['monthly_spend'] ?? null) ? (float) $row['monthly_spend'] : null;

        // Household size
        $row['household_size'] = is_numeric($row['household_size'] ?? null) ? (float) $row['household_size'] : null;

        // created_at -> timestamp
        $row['created_at'] = self::normalizeDateTime($row['created_at'] ?? now());

        return $row;
    }
}
