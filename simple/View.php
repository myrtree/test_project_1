<?php

namespace Simple;

class View
{
    private $templatesPath;
    private $layoutPath;
    private $injectedVars = [];

    public function __construct()
    {
        $settings = Storage::get('settings');
        $this->templatesPath = $settings['templateFolder'];
        $this->layoutPath = $settings['templateFolder'] . $settings['layout'];
    }

    public function render(string $templateName, array $data = [])
    {
        extract($data);
        extract($this->injectedVars);
        ob_start();
        require $this->templatesPath . $templateName .'.php';
        $content = ob_get_contents();
        ob_end_clean();

        require $this->layoutPath;
    }

    public function renderWithoutLayout(string $templateName, array $data = [])
    {
        extract($data);
        extract($this->injectedVars);
        require $this->templatesPath . $templateName .'.php';
    }

    public function injectVars(array $vars)
    {
        $this->injectedVars = $vars;
    }
}
