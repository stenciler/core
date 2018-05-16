<?php
namespace Stencil\Core\Option;


use Stencil\Core\Data;


class Option {
	protected $type = 'option';
	protected $parent;
	protected $name;
	protected $title;
	protected $description;
	protected $icon;
	protected $options = [];
    
	
    public function compose($args = []) {
        foreach ($args as $name => $value) {
            $method = 'set'.join('', array_map('ucfirst', explode('-', $name)));
            if(is_callable(array($this, $method))) {
                call_user_func_array(array($this, $method), array($value));
            }
        }
    }

	protected function add_option($options) {
		$this->options[] = $options;
	}

	protected function add_template($option_id, $template, $args = []) {
		$this->options[] = array_merge([
			'id' => $option_id,
			'type' => 'select',
			'options' => Data::instance()->designs($template)
		], $args);
	}

    public function register_options() {
        
    }

	public function options() {
		return $this->options;
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
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     *
     * @return self
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     *
     * @return self
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

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
}