<?php namespace Bishopm\Blog\Repositories;

use Bishopm\Blog\Repositories\EloquentBaseRepository;

class SettingsRepository extends EloquentBaseRepository
{
    public function get($key, $scope)
    {
        $val=$this->model->where('setting_key', $key)->where('scope', $scope)->first();
        if ($val) {
            return $val->setting_value;
        } else {
            $this->model->create(['setting_key' => $key,'setting_value' => 'Please add a value for this setting','scope' => $scope]);
            return "Invalid";
        }
    }
}
