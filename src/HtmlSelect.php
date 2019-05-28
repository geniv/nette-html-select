<?php declare(strict_types=1);

use GeneralForm\ITemplatePath;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Localization\ITranslator;


/**
 * Class HtmlSelect
 *
 * @author  geniv
 */
class HtmlSelect extends Control implements ITemplatePath
{
    /** @var ITranslator */
    private $translator;
    /** @var string */
    private $templatePath;
    /** @var array */
    private $values = [];
    /** @var array */
    private $parameter;
    /** @var mixed */
    private $active;
    /** @var string */
    private $route;
    /** @var array */
    private $variableTemplate = [];


    /**
     * HtmlSelect constructor.
     *
     * @param ITranslator|null $translator
     */
    public function __construct(ITranslator $translator = null)
    {
        parent::__construct();

        $this->translator = $translator;

        $this->templatePath = __DIR__ . '/HtmlSelect.latte';    // set path
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }


    /**
     * Set route.
     *
     * @param string $route
     */
    public function setRoute(string $route)
    {
        $this->route = $route;
    }


    /**
     * Check route.
     *
     * @throws Exception
     * @internal
     */
    private function checkRoute()
    {
        if (!$this->route) {
            throw new Exception('Please define first method: setRoute');
        }
    }


    /**
     * Set items.
     *
     * @param array $items
     * @param bool  $useKeys
     * @throws Exception
     */
    public function setItems(array $items = [], bool $useKeys = true)
    {
        $this->checkRoute();

        // use same key like value
        if (!$useKeys) {
            $items = array_combine($items, $items);
        }

        // add items
        foreach ($items as $index => $item) {
            $this->addLink($item, $this->route, [$index]);
        }
    }


    /**
     * Add item.
     *
     * @param $option
     * @param $parameter
     * @throws Exception
     */
    public function addItem($option, $parameter)
    {
        $this->checkRoute();

        $this->addLink($option, $this->route, [$parameter]);
    }


    /**
     * Set prompt.
     *
     * @param string $prompt
     * @throws Exception
     */
    public function setPrompt(string $prompt)
    {
        $this->checkRoute();

        $this->addLink($prompt, $this->route, [null]);
    }


    /**
     * Set parameter.
     *
     * @param string      $name
     * @param string|null $default
     */
    public function setParameter(string $name, string $default = null)
    {
        $this->parameter = ['name' => $name, 'default' => $default];
    }


    /**
     * Set active value.
     *
     * @param $active
     */
    public function setActiveValue($active)
    {
        $this->active = $active;
    }


    /**
     * Add link.
     *
     * @param        $option
     * @param string $route
     * @param array  $parameters
     */
    public function addLink($option, string $route, array $parameters)
    {
        $this->values[$option] = [
            'option'     => $option,
            'route'      => $route,
            'parameters' => $parameters,
        ];
    }


    /**
     * Add variable template.
     *
     * @param string $name
     * @param        $values
     */
    public function addVariableTemplate(string $name, $values)
    {
        $this->variableTemplate[$name] = $values;
    }


    /**
     * Render.
     */
    public function render()
    {
        /** @var Template $template */
        $template = $this->getTemplate();

        $values = array_map(function ($row) {
            $row['active'] = false;
            if ($this->parameter && isset($row['parameters'][$this->parameter['name']])) {
                // isset + not empty get value => value or default value
                $value = ($this->presenter->getParameter($this->parameter['name'], $this->parameter['default']) ?: $this->parameter['default']);
                $row['active'] = ($row['parameters'][$this->parameter['name']] == $value);
            } else {
                $row['active'] = in_array($this->active, $row['parameters']);
            }
            return $row;
        }, $this->values);

        // add user defined variable
        foreach ($this->variableTemplate as $name => $value) {
            $template->$name = $value;
        }

        /** @var stdClass $template */
        $template->activeValue = array_filter($values, function ($row) { return $row['active']; }); // select only one item
        $template->activeKey = implode(array_keys($template->activeValue)); // get current key
        $template->values = $values;

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
