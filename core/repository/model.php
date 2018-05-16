<?php
namespace Stencil\Core\Repository;

if ( !defined( 'ABSPATH' ) ) exit;
use Stencil\Core\Template;

class Model {

	protected $template;
	protected $post_type;
	protected $configs = [];
	protected $category = false;
	protected $metadata = [];
	protected $extend = false;
	protected $taxonomies = [];
	protected $metaboxes = [];

	public function __construct($post_type, $configs = []) {
		$this->post_type = $post_type;
		$this->compose($configs);
		$this->template = Template::instance();
	}


    /**
     * @return mixed
     */
    public function getPostType()
    {
        return $this->post_type;
    }

    /**
     * @param mixed $post_type
     *
     * @return self
     */
    public function setPostType($post_type)
    {
        $this->post_type = $post_type;

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
        $this->configs = $this->configs($configs);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     *
     * @return self
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtend()
    {
        return $this->extend;
    }

    /**
     * @param mixed $extend
     *
     * @return self
     */
    public function setExtend($extend)
    {
        $this->extend = $extend;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxonomies()
    {
        return $this->taxonomies;
    }

    /**
     * @param mixed $taxonomies
     *
     * @return self
     */
    public function setTaxonomies($taxonomies)
    {
        $this->taxonomies = $taxonomies;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaboxes()
    {
        return $this->metaboxes;
    }

    /**
     * @param mixed $metaboxes
     *
     * @return self
     */
    public function setMetaboxes($metaboxes)
    {
        $this->metaboxes = $metaboxes;

        return $this;
    }

	public function compose($args = []) {
		foreach ($args as $name => $value) {
			$method = 'set'.join('', array_map('ucfirst', explode('-', $name)));
			if(is_callable(array($this, $method))) {
				call_user_func_array(array($this, $method), array($value));
			}
		}
	}

	public function configs($args) {
		return array_merge(array(
			'labels'                => array(
				'archives'              => __( 'Item Archives', 'stencil' ),
				'attributes'            => __( 'Item Attributes', 'stencil' ),
				'parent_item_colon'     => __( 'Parent Item:', 'stencil' ),
				'all_items'             => __( 'All Items', 'stencil' ),
				'add_new_item'          => __( 'Add New Item', 'stencil' ),
				'add_new'               => __( 'Add New', 'stencil' ),
				'new_item'              => __( 'New Item', 'stencil' ),
				'edit_item'             => __( 'Edit Item', 'stencil' ),
				'update_item'           => __( 'Update Item', 'stencil' ),
				'view_item'             => __( 'View Item', 'stencil' ),
				'view_items'            => __( 'View Items', 'stencil' ),
				'search_items'          => __( 'Search Item', 'stencil' ),
				'not_found'             => __( 'Not found', 'stencil' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'stencil' ),
				'featured_image'        => __( 'Featured Image', 'stencil' ),
				'set_featured_image'    => __( 'Set featured image', 'stencil' ),
				'remove_featured_image' => __( 'Remove featured image', 'stencil' ),
				'use_featured_image'    => __( 'Use as featured image', 'stencil' ),
				'insert_into_item'      => __( 'Insert into item', 'stencil' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'stencil' ),
				'items_list'            => __( 'Items list', 'stencil' ),
				'items_list_navigation' => __( 'Items list navigation', 'stencil' ),
				'filter_items_list'     => __( 'Filter items list', 'stencil' ),
			),
			'supports' => array(
				'title'
			),
			'taxonomies'            => [],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',

		), $args);
	}

	public function metabox($title, $metadata = []) {
		if(!is_array($metadata)) {
			return;
		}
		return array(
			'id'         => 'metadata_metabox',
			'title'      => $title ?? 'Meta Data',
			'post_types' => array($this->post_type),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => $metadata
		);
	}

	

	public function taxonomy($args = []) {
		return array_merge(array(
			'labels'                     => array(
				'all_items'                  => __( 'All Items', 'stencil' ),
				'parent_item'                => __( 'Parent Item', 'stencil' ),
				'parent_item_colon'          => __( 'Parent Item:', 'stencil' ),
				'new_item_name'              => __( 'New Item Name', 'stencil' ),
				'add_new_item'               => __( 'Add New Item', 'stencil' ),
				'edit_item'                  => __( 'Edit Item', 'stencil' ),
				'update_item'                => __( 'Update Item', 'stencil' ),
				'view_item'                  => __( 'View Item', 'stencil' ),
				'separate_items_with_commas' => __( 'Separate items with commas', 'stencil' ),
				'add_or_remove_items'        => __( 'Add or remove items', 'stencil' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'stencil' ),
				'popular_items'              => __( 'Popular Items', 'stencil' ),
				'search_items'               => __( 'Search Items', 'stencil' ),
				'not_found'                  => __( 'Not Found', 'stencil' ),
				'no_terms'                   => __( 'No items', 'stencil' ),
				'items_list'                 => __( 'Items list', 'stencil' ),
				'items_list_navigation'      => __( 'Items list navigation', 'stencil' ),
			),
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		), $args);
	}



	public function register() {
		$post_type = $this->post_type;
		$configs = $this->configs;
		$taxonomies = $this->taxonomies;
		$metaboxes = $this->metaboxes;
		if(!$this->extend) {
			add_action('init', function () use ($post_type, $configs) {
				register_post_type( $post_type, $configs);
			}, 10);
		}

		if($this->category) {
			$category = $post_type.'_category';
			$args = $this->taxonomy();
			add_action('init', function () use ($post_type, $category, $args) {
				register_taxonomy( $category, array($post_type), $args);
			}, 0);
		}
		
		if(count($this->metadata) > 0) {
			$metadata = $this->metabox('Meta Data', $this->metadata);
			add_filter( 'rwmb_meta_boxes', function($meta_boxes) use ($metadata) {
				$meta_boxes[] = $metadata;
				return $meta_boxes;
			});	
		
		}
	}
}