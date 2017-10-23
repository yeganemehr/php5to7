import * as $ from "jquery";
import * as Dropzone from "dropzone";
import {Router, AjaxRequest} from "webuilder";
import * as he from "he";
import * as hljs from "highlight.js";
import "jquery.growl";

interface MigrationResponseFileChange{
	line:number;
	type:string;
	from?:string;
	to?:string;
}
interface MigrationResponseFile{
	name:string;
	content:string;
	md5:string;
	changes:MigrationResponseFileChange[];
}
interface MigrationResponse{
	status: boolean;
	files:MigrationResponseFile[];
}
export default class FileUpload{
	protected static $form:JQuery;
	protected static myDropzone:Dropzone;
	protected static SetDropZone(){
		FileUpload.myDropzone = new Dropzone('#upload_form',{
			url: Router.getAjaxFormURL(FileUpload.$form.attr('action')),
			paramName: "file",
            maxFilesize: 1024*1024*2,
			dictRemoveFile: "حذف فایل",
			dictDefaultMessage: "فایل های خود را به اینجا بکشید",
			dictCancelUpload:"انصراف از آپلود",
			addRemoveLinks:false,
			success: function(file: Dropzone.DropzoneFile, response:MigrationResponse){
				$('.box-remove').remove();
				for(const file of response.files){
					let changes:string = "";
					for(const change of file.changes){
						let message:string;
						switch(change.type){
							case('change-function-name'):
								message = `نام تابع از <code>${change.from}</code> به <code>${change.to}</code> تغییر کرد.`;
								break;
							case('change-method-name'): 
								message = `نام متد از <code>${change.from}</code> به <code>${change.to}</code> تغییر کرد.`;
								break;
							case('change-keyword'):
								message = `کلمه کلیدی <code>${change.from}</code> به <code>${change.to}</code> تغییر کرد.`;
								break;
							case('new-variable'):
								message = `یک متغییر جدید تعریف شد.`;
								break;
							case('change-expr'):
								message = `عبارت <code>${change.from}</code> تغییر کرد.`;
								break;

						}
						if(message){
							changes += `<p><i class="fa fa-info-circle"></i> <a href="#L${change.line}">خط ${change.line}</a>: ${message}</p>`;
						}
					}
					let html = `<div class="file-preview">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading" style="overflow:hidden">
				<div class="pull-right">${changes ? 'توضیحات و تغییرات' : ''}</div>
				<div class="pull-left text-left ltr">
					<i class="fa fa-file-text-o"></i> <strong>${file.name}</strong>
					<a class="btn btn-sm btn-default" href="${Router.url('download/'+file.md5)}" target="_blank"><i class="fa fa-download"></i></a>
					<a class="btn btn-sm btn-default" href="${Router.url('raw/'+file.md5)}" target="_blank"><i class="fa fa-file-code-o"></i></a>
					<a class="btn btn-sm btn-default btn-remove" href="${Router.url('remove/'+file.md5)}" target="_blank"><i class="fa fa-trash-o"></i></a>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">`;
					if(changes){
						html += `<div class="col-lg-4">
							<div class="notice">
								${changes}
							</div>
						</div>
						<div class="col-lg-8">
							<div class="preview-code">
								<pre><code class="php">${he.encode(file.content)}</code></pre>
							</div>
						</div>`;
					}else{
						html += `<div class="col-lg-12">
							<div class="preview-code">
								<pre><code class="php">${he.encode(file.content)}</code></pre>
							</div>
						</div>`;
					}
					html += `</div>
						</div>
					</div>
				</div>
			</div>`;
					const $filePreview = $(html).insertAfter($('.landing-top'));
					FileUpload.runRemoveBtn($filePreview);
					hljs.highlightBlock($('pre code', $filePreview)[0]);
					$('code.hljs', $filePreview).each(function(i, block) {
						(hljs as any).lineNumbersBlock(block);
					});
					
				}
				
			}
        });
	}
	private static runRemoveBtn($box:JQuery){
		$('.btn-remove', $box).on('click', function(e){
			e.preventDefault();
			if($(this).hasClass('disabled')){
				return;
			}
			$(this).addClass('disabled');
			$(this).data('html', $(this).html());
			$(this).html('<i class="fa fa-spain fa-spinner"></i>');
			AjaxRequest({
				type:"GET",
				url: $(this).attr('href'),
				data:{
					ajax:1
				},
				dataType:'json',
				success: (data) => {
					$(this).removeClass('disabled');
					$(this).html($(this).data('html'));
					if(data.status){
						$.growl.notice({
							title: "موفقیت آمیز!",
							message: "فایل با موفقیت حذف شد.",
						});
						$(this).parents('.file-preview').remove();
					}
				},
				error: function(){
					$(this).removeClass('disabled');
					$(this).html($(this).data('html'));
					$.growl.error({
						title: "خطا",
						message: "امکان اتصال به سرور وجود ندارد",
					});
				}
			})
		});
	}
	public static init(){
		FileUpload.SetDropZone();
		FileUpload.runRemoveBtn($('body'));
	}
	public static initIfNeeded(){
		FileUpload.$form = $('#upload_form');
		if(FileUpload.$form.length){
			FileUpload.init();
		}
	}
};
