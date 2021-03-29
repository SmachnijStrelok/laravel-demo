<?php

namespace App\Http\Components\Department\UseCase\Update;

use App\Http\Components\User\Entities\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UpdateDepartmentRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description.*' => ['string'],
            'logo_id' => ['integer', 'nullable', 'exists:uploaded_files,id'],
        ];
    }
}
