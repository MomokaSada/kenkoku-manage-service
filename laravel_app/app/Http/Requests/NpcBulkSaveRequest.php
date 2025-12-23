<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NpcBulkSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'store.*.name' => 'required|string|max:255|unique:npcs,name|distinct',
            'store.*.biome_id' => 'required|exists:biomes,id',
            'store.*.profession_id' => 'required|exists:professions,id',
            'store.*.type' => 'required|exists:npc_types,id',
            
            'patch.*.id' => 'required|exists:npcs,id',
            'patch.*.name' => [
                'sometimes',
                'string',
                'max:255',
                'distinct',
                function ($attribute, $value, $fail) {
                    // Custom validation to ignore unique check for self
                    // attribute format: patch.0.name
                    $index = explode('.', $attribute)[1];
                    $id = $this->input("patch.{$index}.id");
                    
                    if ($id) {
                         $exists = \App\Models\Npc::where('name', $value)->where('id', '!=', $id)->exists();
                         if ($exists) {
                             $fail('The name has already been taken.');
                         }
                    }
                },
            ],
            
            'delete.*' => 'exists:npcs,id',
        ];
    }

    public function attributes()
    {
        return [
            'store.*.name' => 'NPC Name',
            'store.*.biome_id' => 'Biome',
            'store.*.profession_id' => 'Profession',
            'store.*.type' => 'NPC Type',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
