<?php

namespace Devzone\UserManagement\Traits;

use App\Models\Option;
use App\Models\World\Country;

trait LogActivityManualTrait
{

    public function logDescription($changes, $originals)
    {
        $description = '';

        foreach ($changes as $field => $new) {

            if ($field === 'updated_at') {
                continue;
            }

            $old = $originals[$field];

            if ($new != $old) {

                $values = $this->valuesAssign($field, $old, $new);

                $description .= ucwords(str_replace(' id', '', str_replace('_', ' ', $field)))
                    . ' changed from "' . (!empty($values['old_value']) ? $values['old_value'] : 'None')
                    . '" to "' . (!empty($values['new_value']) ? $values['new_value'] : 'None') . '". ';
            }
        }
        return $description;
    }

    public function valuesAssign($value_name, $old_value, $new_value)
    {
        if ($value_name == 'gender') {
            $new_value = ($new_value == 'm') ? 'Male' : 'Female';
            $old_value = ($old_value == 'm') ? 'Male' : 'Female';
        } elseif ($value_name == 'status') {
            $new_value = ($new_value == 't') ? 'Active' : 'In-active';
            $old_value = ($old_value == 't') ? 'Active' : 'In-active';
        } elseif ($value_name == 'is_verified' || $value_name == 'verify') {
            $new_value = ($new_value == 't') ? 'Yes' : 'No';
            $old_value = ($old_value == 't') ? 'Yes' : 'No';
        }
        return ['old_value' => $old_value, 'new_value' => $new_value];
    }

}
