		<!-- 坑人的模板 -->
			<div class="row calender widget-shadow" style="display:none">
					<h4 class="title">Calender</h4>
					<div class="cal1"></div>
				</div>
			<div class="clearfix"> </div>
		</div>
		<!-- 右边内容结束 -->
		<!--下边内容开始-->
		<div class="footer">
		   <p>Welcome to my project!</p>
		</div>
		<!--下边内容结束-->
  
	</div>
	<!-- Classie -->
		<script src="/admin/js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}

		</script>
	<!--scrolling js-->
	<script src="/admin/js/jquery.nicescroll.js"></script>
	<script src="/admin/js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="/admin/js/bootstrap.js"> </script>
</body>
</html>