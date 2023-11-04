<?php

namespace OmniaDigital\CatalystCore\Models\Forms;

use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OmniaDigital\CatalystCore\Models\TeamApplication;
use OmniaDigital\CatalystForms\Models\Form;

class FormSubmission extends \OmniaDigital\CatalystForms\Models\FormSubmission
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'team_id',
        'user_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teamApplication()
    {
        return $this->hasOne(TeamApplication::class);
    }
}
