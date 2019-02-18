<?php

	class PluginTailWriter extends Plugin{
		/*
		 |	LIST OF CONTROLLERS TO LOAD
		 */
		private $loadOnController = array(
			"new-content", "edit-content"
		);

		/*
		 |	HOOK :: ADMIN HEAD
		 |	@since	0.1.0
		 */
		public function adminHead(){
			if(!in_array($GLOBALS["ADMIN_CONTROLLER"], $this->loadOnController)){
				return false;
			}

			// CSS
			$html  = '<link type="text/css" rel="stylesheet" href="' . $this->htmlPath() . 'vendors/tail-writer/css/tail.writer.css" />' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="' . $this->htmlPath() . 'vendors/tail-writer/css/tail.writer.github.css" />' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="' . $this->htmlPath() . 'vendors/bludit/css/style.css" />' . PHP_EOL;

			// JavaScript
			$html .= '<script type="text/javascript" src="' . $this->htmlPath() . 'vendors/marked/marked.min.js"></script>' . PHP_EOL;
			$html .= '<script type="text/javascript" src="' . $this->htmlPath() . 'vendors/tail-writer/js/tail.writer.min.js"></script>' . PHP_EOL;
			return $html;
		}

		/*
		 |	HOOK :: ADMIN HEAD
		 |	@since	0.1.0
		 */
		public function adminBodyEnd(){
			if(!in_array($GLOBALS["ADMIN_CONTROLLER"], $this->loadOnController)){
				return false;
			}

			ob_start();
			?>
				<script type="text/javascript">
					var WriterEditor = null;

					function editorInsertMedia(file){
						var select = WriterEditor.selection(),
							__1 = WriterEditor.val.slice(0, select.start),
							__2 = WriterEditor.val.slice(select.start, select.end),
							__3 = WriterEditor.val.slice(select.end);
						WriterEditor.write(__1 + "![Image description](" + file + ")" + __3);
					}

					function editorGetContent(){
						return document.getElementById("js-tail-writer").value;
					}

					document.addEventListener("DOMContentLoaded", function(){
						var area = document.querySelector("#jseditor"),
							text = document.createElement("textarea");
							text.id = "js-tail-writer";
							text.value = area.innerHTML;
							text.className = area.className;

						// Instance
						area.innerHTML = "";
						area.appendChild(text, area);
						WriterEditor = tail.writer("#js-tail-writer")[0];
					});
				</script>
			<?php
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
	}
