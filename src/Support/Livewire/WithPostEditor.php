<?php

namespace OmniaDigital\CatalystCore\Support\Livewire;

use Illuminate\Validation\Validator;

trait WithPostEditor
{
    public function validatePostEditor(array $rules = ['required'], string $property = 'content'): array
    {
        return $this->withPostEditorEvent()->validate([
            $property => $rules,
        ]);
    }

    public function withPostEditorEvent(): self
    {
        return $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $this->emitPostValidated($validator);
            });
        });
    }

    public function emitPostValidated(Validator $validator)
    {
        $this->dispatch('validationFailed', errors: $validator->errors())->to('catalyst-social::post-editor');
    }

    public function emitPostSaved(string $editorId)
    {
        $this->dispatch('postSaved:' . $editorId)->to('catalyst-social::post-editor');
        $this->dispatch('postSaved')->to('catalyst-social::news-feed');
    }
}
