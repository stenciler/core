<?php


stencil()->template('header', [
	'name' => 'standard',
	'template' => 'header/standard.php'
]);
stencil()->template('footer', [
	'name' => 'standard',
	'template' => 'footer/standard.php'
]);

stencil()->template('container', [
	'name' => 'standard',
	'template' => 'container/standard.php'
]);
stencil()->template('container', [
	'name' => '2column',
	'template' => 'container/2column.php'
]);
stencil()->template('container', [
	'name' => '3column',
	'template' => 'container/3column.php'
]);
stencil()->template('container', [
	'name' => '2column_left',
	'template' => 'container/2column_left.php'
]);

stencil()->template('article', [
	'name' => 'standard',
	'template' => 'article/standard.php'
]);
stencil()->template('article', [
	'name' => 'blog',
	'template' => 'article/blog.php'
]);
stencil()->template('article', [
	'name' => 'canvas',
	'template' => 'article/canvas.php'
]);





stencil()->template('collection', [
	'name' => 'standard',
	'template' => 'collection/standard.php',
	'options' => [
		[
			'type' => 'text',
			'id' => 'posts_per_page',
			'name' => 'Posts Per Page'
		]
	]
]);


stencil()->template('collection', [
	'name' => 'masonary',
	'template' => 'collection/masonary.php'
]);
stencil()->template('collection', [
	'name' => 'accordion',
	'template' => 'collection/accordion.php'
]);
stencil()->template('collection', [
	'name' => 'slideshow',
	'template' => 'collection/slideshow.php'
]);

stencil()->template('item', [
	'name' => 'standard',
	'template' => 'item/standard.php'
]);

stencil()->template('item', [
	'name' => 'list',
	'template' => 'item/list.php'
]);

stencil()->template('item', [
	'name' => 'grid',
	'template' => 'item/grid.php'
]);


//register post
stencil()->model(
	'post',
	[
		'extend' => true,
		'metadata' => [
			[
				'type' => 'select',
				'name' => 'Cover Type',
				'id'   => '_cover_type',
				'options' => [
					'' 		=> 'None',
					'image' => 'Image',
					'video' => 'Video',
					'map' => 'Map'
				]
			],
			[
				'type' => 'file_input',
				'name' => 'Cover URL/File',
				'id'   => '_cover_url'
			],
			[
				'type' => 'select',
				'name' => 'Overlay Color',
				'id'   => '_cover_overlay',
				'options' => [
					'' => 'None',
					'overlay-dark' => 'Dark',
					'overlay-light' => 'Light'
				]
			],
			[
				'type' => 'select',
				'name' => 'Overlay Opacity',
				'id'   => '_cover_opacity',
				'options' => [
					'' => 'Standard',
					'overlay-10' => '10',
					'overlay-20' => '20',
					'overlay-30' => '30',
					'overlay-40' => '40',
					'overlay-50' => '50',
					'overlay-60' => '60',
					'overlay-70' => '70',
					'overlay-90' => '90',
					'overlay-100' => '100'
				]
			],
			[
				'type' => 'textarea',
				'name' => 'Content',
				'id'   => '_cover_content'
			]
		]
	]
);
stencil()->model(
	'page',
	[
		'extend' => true,
		'metadata' => [
			[
				'type' => 'select',
				'name' => 'Cover Type',
				'id'   => '_cover_type',
				'options' => [
					'' 		=> 'None',
					'image' => 'Image',
					'video' => 'Video',
					'map' => 'Map'
				]
			],
			[
				'type' => 'file_input',
				'name' => 'Cover URL/File',
				'id'   => '_cover_url'
			],
			[
				'type' => 'select',
				'name' => 'Overlay Color',
				'id'   => '_cover_overlay',
				'options' => [
					'' => 'None',
					'overlay-dark' => 'Dark',
					'overlay-light' => 'Light'
				]
			],
			[
				'type' => 'select',
				'name' => 'Overlay Opacity',
				'id'   => '_cover_opacity',
				'options' => [
					'' => 'Standard',
					'overlay-10' => '10',
					'overlay-20' => '20',
					'overlay-30' => '30',
					'overlay-40' => '40',
					'overlay-50' => '50',
					'overlay-60' => '60',
					'overlay-70' => '70',
					'overlay-90' => '90',
					'overlay-100' => '100'
				]
			],
			[
				'type' => 'textarea',
				'name' => 'Content',
				'id'   => '_cover_content'
			]
		]
	]
);