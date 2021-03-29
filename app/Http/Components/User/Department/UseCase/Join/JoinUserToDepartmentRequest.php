<?php

namespace App\Http\Components\User\Department\UseCase\Join;

use App\Http\Components\User\Entities\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JoinUserToDepartmentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user() instanceof User && \Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['integer', 'exists:users,id'],
            'department_id' => ['integer', 'exists:departments,id', Rule::unique('department_to_users')->where('user_id', $this->user_id)->where('department_id', $this->department_id)],
        ];
    }

}
