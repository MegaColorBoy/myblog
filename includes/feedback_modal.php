<div class="modal fade" id="feedback" tabindex="-1" role="dialog"  data-backdrop="false" aria-labelledby="dwnld_img_modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><span class="fa fa-question-circle"></span> Any questions? Feel free to contact me.</h4>	
			</div>
			<div class="modal-body">
				<form id="feedback_form" class="form-horizontal" name="feedback_form" method="post" action="">
					<div class="form-group">
						<div class="col-lg-6 col-sm-6 col-md-6">
							<input required placeholder="First name" type="text" class="form-control" id="fname" name="fname" 
							value='<?php if(isset($error)){}?>'/>
						</div>
						<div class="col-lg-6 col-sm-6 col-md-6">
							<input required placeholder="Last name" type="text" class="form-control" id="lname" name="lname" 
							value='<?php if(isset($error)){}?>'/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12">
						<input required placeholder="Email Address" type="email" class="form-control" id="email" name="email" 
						value='<?php if(isset($error)){}?>'/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<textarea required class="form-control" id="query" name="query" placeholder="Type your message..."
							value='<?php if(isset($error)){}?>' rows="5"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<button type="submit" name="feedback_submit" class="btn btn-success btn-block send_msg_btn"><span class="fa fa-paper-plane"></span> 
							Send</button>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6">
							<button type="reset" name="clear" class="btn btn-danger btn-block"><span class="fa fa-trash"></span> 
							Clear</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div> 