<?php
/*
 |  tail.writer 4 Bludit
 |  @file       ./plugin.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.3.3 [0.3.2] - Alpha
 |
 |  @website    https://github.com/pytesNET/tail.writer-bludit
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2019 pytesNET <info@pytes.net>
 */
	class PluginTailWriter extends Plugin{
		/*
		 |	LIST OF CONTROLLERS TO LOAD
		 */
		private $loadOnController = array(
			"new-content", "edit-content"
		);

		/*
		 |	HOOK :: ADMIN HEAD
		 |	@since	0.3.3
		 */
		public function adminHead(){
			if(!in_array($GLOBALS["ADMIN_CONTROLLER"], $this->loadOnController)){
				return false;
			}

			// CSS
			$html  = '<link type="text/css" rel="stylesheet" href="' . $this->htmlPath() . 'vendors/tail-writer/css/tail.writer.css" />' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="' . $this->htmlPath() . 'vendors/tail-writer/css/tail.writer.github.css" />' . PHP_EOL;

			// JavaScript
			$html .= '<script type="text/javascript" src="' . $this->htmlPath() . 'vendors/marked/marked.min.js"></script>' . PHP_EOL;
			$html .= '<script type="text/javascript" src="' . $this->htmlPath() . 'vendors/tail-writer/js/tail.writer.min.js"></script>' . PHP_EOL;
			return $html;
		}

		/*
		 |	HOOK :: ADMIN HEAD
		 |	@since	0.3.3
		 */
		public function adminBodyEnd(){
			if(!in_array($GLOBALS["ADMIN_CONTROLLER"], $this->loadOnController)){
				return false;
			}

			ob_start();
			if(version_compare(BLUDIT_VERSION, "3.8.0", ">=")){
				$this->version38();
			} else {
				$this->version35();
			}
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}

		/*
		 |	INTERNAL :: SCRIPT FOR VERSION >= 3.8.0
		 |	@since	0.3.3
		 */
		private function version38(){
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
						return document.getElementById("jseditor").value;
					}

					document.addEventListener("DOMContentLoaded", function(){
						WriterEditor = tail.writer("#jseditor")[0];
					});
				</script>
				<style type="text/css">
					#jseditor{
						padding: 15px !important;
						max-height: none !important;
					}
					.tail-writer-object{
						display: flex;
						flex-direction: column;
						flex: 1;
						align-items: stretch;
					}
					.tail-writer-preview img{
						max-width: 100%;
					}
				</style>
			<?php
		}

		/*
		 |	INTERNAL :: SCRIPT FOR VERSION < 3.8.0
		 |	@since	0.3.3
		 */
		private function version35(){
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
				<style type="text/css">
					#jseditor{
						padding: 10px 0 !important;
						max-height: none !important;
					}
					.tail-writer-object{
						display: flex;
						flex-direction: column;
						flex: 1;
						align-items: stretch;
					}
					.tail-writer-preview img{
						max-width: 100%;
					}
				</style>
			<?php
		}
	}
