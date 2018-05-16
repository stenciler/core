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

stencil()->template('static', [
	'name' => 'standard',
	'template' => 'static/standard.php'
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
				'name' => 'Cover URL',
				'id'   => '_cover_url'
			],
			[
				'type' => 'select',
				'name' => 'Cover Color',
				'id'   => '_cover_overlay',
				'options' => [
					'' => 'None',
					'overlay-dark' => 'Dark',
					'overlay-light' => 'Light'
				]
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
					'map' => 'Map',
					'slideshow' => 'Slideshow(*)',
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
				'name' => 'Overlay Level',
				'id'   => '_cover_level',
				'options' => [
					'' => 'Standard',
					'10' => '10',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'90' => '90',
					'90' => '90'
				]
			],
			[
				'type' => 'wysiwyg',
				'name' => 'Hero Content',
				'id'   => '_cover_content'
			]
		]
	]
);