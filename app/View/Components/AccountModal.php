<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AccountModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $formAction,
        public string $modalTitle = 'Create Account',
        public string $buttonLabel = 'Add Account',
        public string $submitLabel = 'Save',
        public string|bool $showOnError = false,
    ) {}
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.account-modal');
    }
}
