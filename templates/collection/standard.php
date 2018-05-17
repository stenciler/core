{{#posts}}
<div class="collection">
	{{#posts_filter}}{{/posts_filter}}
	<div class="{{_row_class}}">
		{{#posts_loop}}
		<div class="{{_column_class}}">
			{{#posts_item}}
			{{/posts_item}}
		</div>
		{{/posts_loop}}

	</div>
	{{#posts_pagination}}{{/posts_pagination}}
</div>
{{/posts}}

