<?php

namespace Devzone\UserManagement\Traits;

use App\Models\Option;
use App\Models\World\Country;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Schema;

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
                    . ' changed from "' . (!empty($values['old_value']) ? $values['old_value'] : 'Empty')
                    . '" to "' . (!empty($values['new_value']) ? $values['new_value'] : 'Empty') . '". ';
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

    public function auditLog($performed_on, $target_id, $log_name, $description)
    {
        if (Schema::hasTable('activity_log') && Schema::hasColumn('activity_log', 'target_id')) {
            if (!empty($description)) {
                activity()
                    ->causedBy(\auth()->id())
                    ->performedOn($performed_on)
                    ->tap(function (Activity $activity) use ($target_id, $log_name) {
                        $activity->target_id = $target_id ?? null;
                        $activity->log_name = $log_name;
                    })
                    ->log($description);
            }
        }
    }

}
