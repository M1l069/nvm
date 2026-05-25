<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'start_date', 'end_date', 'is_active'])]
class SchoolYear extends Model
{
    protected function casts():array {
        return [
            'start-date' => 'date',
            'end-date' => 'date',
            'is_active' => 'boolean'
        ];
    }

    public function subjectSchoolYears():HasMany
    {
        return $this->hasMany(SubjectSchoolYear::class);
    }

    public static function active(): self
    {
        return static::where('is_active', true)->firstOrFail();
    }

    public function activate():void {
        static::query()->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

}
