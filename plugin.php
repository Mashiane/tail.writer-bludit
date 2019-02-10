<?php

class pluginTailWriter extends Plugin {

	// List of controllers where the plugin is loaded
	private $loadOnController = array(
		'new-content',
		'edit-content'
	);

	public function adminHead()
	{
		// Load the plugin only in the controllers setted in $this->loadOnController
		if (!in_array($GLOBALS['ADMIN_CONTROLLER'], $this->loadOnController)) {
			return false;
		}

		// CSS
		$html  = '<link type="text/css" rel="stylesheet" href="'.$this->htmlPath().'vendors/tail-writer/css/tail.writer.css" />'.PHP_EOL;
		$html .= '<link type="text/css" rel="stylesheet" href="'.$this->htmlPath().'vendors/tail-writer/css/tail.writer.github.css" />'.PHP_EOL;
		$html .= '<link type="text/css" rel="stylesheet" href="'.$this->htmlPath().'vendors/bludit/css/style.css" />'.PHP_EOL;

		// Javascript
		$html .= '<script src="'.$this->htmlPath().'vendors/marked/marked.min.js"></script>'.PHP_EOL;
		$html .= '<script src="'.$this->htmlPath().'vendors/tail-writer/js/tail.writer.min.js"></script>'.PHP_EOL;
		return $html;
	}

	public function adminBodyEnd()
	{
		// Load the plugin only in the controllers setted in $this->loadOnController
		if (!in_array($GLOBALS['ADMIN_CONTROLLER'], $this->loadOnController)) {
			return false;
		}

$html = <<<EOF
<script>
	var tailWriter = null;

	// Insert an image in the editor at the cursor position
	// Function required for Bludit
	function editorInsertMedia(filename) {
		var firstElement
		var select = tailWriter.selection(),
		__1 = tailWriter.val.slice(0, select.start),
		__2 = tailWriter.val.slice(select.start, select.end),
		__3 = tailWriter.val.slice(select.end, tailWriter.val.length);
		tailWriter.write(__1 + "![Image description]("+filename+")" + __3);
	}

	// Returns the content of the editor
	// Function required for Bludit
	function editorGetContent() {
		return document.getElementById("jseditor").value;
	}

	document.addEventListener("DOMContentLoaded", function(){
		tailWriter = tail.writer("#jseditor")[0];
		console.log(tailWriter);
	});
</script>
EOF;
		return $html;
	}

}