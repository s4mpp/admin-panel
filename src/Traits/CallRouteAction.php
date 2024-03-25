<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Support\Str;

trait CallRouteAction
{
    private ?string $action = null;

    private string $method = 'GET';

    private string|Closure|null $success_message = null;

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getUrl(): ?string
    {
        $route_name = $this->getResource()->getRouteName($this->getSlug() ?? '');

        if(!$route_name)
        {
            return null;
        }

        return route($route_name, ['id' => $this->getRegister()->id]);
    }

    public function setSuccessMessage(string|Closure $success_message): self
    {
        $this->success_message = $success_message;

        return $this;
    }

    /**
     * @param  array<string>|null  $result
     */
    public function getSuccessMessage(mixed $result = null): string
    {
        $message = $this->success_message;

        if (is_callable($message)) {
            
            $message = call_user_func($message, $result);
        }

        /** @var string|null $message */
        return Str::of($message ?? 'Ação concluída com sucesso.')->inlineMarkdown();
    }
}
