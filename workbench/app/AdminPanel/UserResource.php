<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\UserResource as MainUserResource;

final class UserResource extends MainUserResource
{
	/**
     * @return array<LabelElement|Card>
     */
    public function table(): array
    {
		return array_merge(parent::table(), [

			Label::dateTime('Atualizado em', 'updated_at')
		]);
    }
}
