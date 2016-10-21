</div> 
    </div>
</div>
	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

		


		<!-- script for the comment box -->
		<script type="text/javascript">
			$(function(){
				//When clicked on the new_cmt_btn, show the comment box
				$('.new_cmt_btn').click(function(event){
					$(this).hide();
					$('.new_cmt_box').fadeIn('fast');
					$('#cmt_user').focus();
				});

				//Activate the "add_cmt_btn" while writing
				$('.cmt_content').bind('input propertychange', function(){
					$('#add_cmt_btn').css({opacity:0.6});
					var checkLength = $(this).val().length;
					if(checkLength)
					{
						$('#add_cmt_btn').css({opacity:1});
					}
				});

				//When clicked on the add_cmt_btn
				$('#add_cmt_btn').click(function(event){
					var cmt_user = $("#cmt_user");
					var cmt_email = $("#cmt_email");
					var comment = $(".cmt_content");

					if(!comment.val() || !cmt_email.val())
					{
						alert("Please write a comment and your email address!");
					}
					else
					{
						$.ajax({
							type: "POST",
							url: "includes/add_comment.php",
							data: 'action=add_cmt&bp_id='+<?php echo $bp_id;?>
							+'&username='+cmt_user.val()+'&email='+cmt_email.val()
							+'&comment='+comment.val(),
							success: function(html){
								cmt_user.val('');
								cmt_email.val('');
								comment.val('');
								$('.new_cmt_box').hide('fast', function(){
									$('.new_cmt_btn').show('fast');
									$('.new_cmt_btn').before(html);
								})
							}
						});
					}
				});

				//When clicked on the cancel_btn
				$('#cancel_btn').click(function(event){
					$('.cmt_content').val('');
					$('.new_cmt_box').fadeOut('fast', function(){
						$(".new_cmt_btn").fadeIn('fast');
					});
				});
			});
		</script>

		<!-- script for the feedback modal -->
		<script type="text/javascript">
			$(function(){
				//When you click the send message button
				$('.send_msg_btn').click(function(event){
					var fname = $("#fname");
					var lname = $("#lname");
					var sender_email = $("#email");
					var sender_query = $("#query");

					if(!fname.val() || !lname.val() || !sender_email.val() || !sender_query.val())
					{
						alert("Please fill out the missing fields!");
					}
					else
					{
						$.ajax({
							type: "POST",
							url: "includes/send_message.php",
							data: 'action=send_msg&name=' + fname.val() + lname.val() + 
							'&email=' + sender_email.val() +
							'&message=' + sender_query.val(),
							success: function(html){
								fname.val('');
								lname.val('');
								sender_email.val('');
								sender_query.val('');
								alert("DDDDDDDD");
							}
						});
					}

				});
			});
		</script>

		<!-- /script for the feedback modal -->
	</body>
</html>