<?php declare(strict_types=1);

use GeneralForm\ITemplatePath;
use Nette\Application\UI\Control;
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
    private $values;
    /** @var array */
    private $parameter;
    /** @var mixed */
    private $active;


    /**
     * HtmlSelect constructor.
     *
     * @param ITranslator|null $translator
     */
    public function __construct(ITranslator $translator = null)
    {
        parent::__construct();

        $this->translator = $translator;

        $this->templatePath = __DIR__ . '/HtmlSelect.latte'; // set path
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
     * Render.
     */
    public function render()
    {
        $template = $this->getTemplate();

        $values = array_map(function ($row) {
            $value = $this->presenter->getParameter($this->parameter['name'], $this->parameter['default']);
            $row['active'] = false;
            if (isset($row['parameters'][$this->parameter['name']])) {
                $row['active'] = ($row['parameters'][$this->parameter['name']] == $value);
            } else {
                $row['active'] = in_array($this->active, $row['parameters']);
            }
            return $row;
        }, $this->values);

        $template->activeValue = array_filter($values, function ($row) { return $row['active']; });
        $template->values = $values;

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
