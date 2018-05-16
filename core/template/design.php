<?php
namespace Stencil\Core\Template;


class Design  {
	
    protected $type = 'normal';
    protected $provider;
    protected $name;
    protected $autor;
    protected $autor_url;
    protected $storage;
    protected $storage_id = null;
    protected $markup;
    protected $js;
    protected $css;
    protected $options = [];
    protected $values = [];
    protected $configs = [];
    protected $template = null;

    public function __construct() {

    }

    public function compose($args = []) {
        foreach ($args as $name => $value) {
            $method = 'set'.join('', array_map('ucfirst', explode('-', $name)));
            if(is_callable(array($this, $method))) {
                call_user_func_array(array($this, $method), array($value));
            }
        }
    }
    
    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     *
     * @return self
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     *
     * @return self
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutorUrl()
    {
        return $this->autor_url;
    }

    /**
     * @param mixed $autor_url
     *
     * @return self
     */
    public function setAutorUrl($autor_url)
    {
        $this->autor_url = $autor_url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param mixed $storage
     *
     * @return self
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStorageId()
    {
        return $this->storage_id;
    }

    /**
     * @param mixed $storage_id
     *
     * @return self
     */
    public function setStorageId($storage_id)
    {
        $this->storage_id = $storage_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMarkup()
    {
        return $this->markup;
    }

    /**
     * @param mixed $markup
     *
     * @return self
     */
    public function setMarkup($markup)
    {
        $this->markup = $markup;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * @param mixed $js
     *
     * @return self
     */
    public function setJs($js)
    {
        $this->js = $js;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param mixed $css
     *
     * @return self
     */
    public function setCss($css)
    {
        $this->css = $css;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     *
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param mixed $values
     *
     * @return self
     */
    public function setValues($values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * @param mixed $configs
     *
     * @return self
     */
    public function setConfigs($configs)
    {
        $this->configs = $configs;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     *
     * @return self
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

}