<?php
namespace Stencil\Core\Field;


class Code  extends Field_Base   {

	public function show($id, $args = []) {
		$output = '';
		$output .= '<div class="field-input">';
		$output .= sprintf('<div id="%s" class="code-field">%s</div>',
			esc_attr($id),
			$this->value($args)
		);
		$output .= sprintf('<input id="%s-data" name="%s" type="hidden" value="%s" />',
			esc_attr($id),
			esc_attr($id),
			$this->value($args)
		);
		ob_start();
		?>
		<script>
			var flask = new CodeFlask;
			flask.run('#<?php echo $id; ?>');
			flask.onUpdate(function(code) {
				document.getElementById("<?php echo $id; ?>-data").setAttribute('value',code);
			});
		</script>
		<style>
		#<?php echo $id; ?> textarea {
			width: 100%;
		}
		.CodeFlask__code {
			display: none;
		}
	</style>
	<?php
	$output .= ob_get_clean();
	$output .= '</div>';
	return $output;
}
}