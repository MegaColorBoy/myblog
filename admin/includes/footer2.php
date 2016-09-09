</body>
<footer class="container-fluid text-center">
	<p>MegaColorBoy &copy; 2016</p>
</footer>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
	tinymce.init({
		selector: "textarea",
		plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste"
		],
		toolbar: "insertfile undo redo | stylesheet | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
</script>

<script>
	//for image uploading
	$(function(){
		$("#uploadFile").on("change", function(){
			var files = !!this.files ? this.files : [];

			if(!files.length || !window.FileReader){return;}

			if(/^image/.test(files[0].type))
			{
				var reader = new FileReader();
				reader.readAsDataURL(files[0]);
				reader.onloadend = function()
				{
					$("#imgpreview").css("background-image", "url("+this.result+")");
				}
			}
		});
	});
</script>
</html>