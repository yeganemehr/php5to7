import * as $ from "jquery";
import FileUpload from "./FileUpload";
import * as Dropzone from "dropzone";
import * as hljs from "highlight.js";
(window as any).hljs = hljs;
import "highlightjs-line-numbers.js";
(Dropzone as any).autoDiscover = false;
hljs.configure({
	tabReplace:'    '
});
hljs.initHighlightingOnLoad();
(hljs as any).initLineNumbersOnLoad();
$(() => {
	FileUpload.initIfNeeded();
});