		<div class="wrap">
		<div class="Header"><h2><?php _e("Status Tracking Settings", 'order-tracking') ?></h2></div>

		<?php if ($EWD_OTP_Full_Version != "Yes" or get_option("EWD_OTP_Trial_Happening") == "Yes") { ?>
			<div class="ewd-otp-dashboard-new-upgrade-banner">
				<div class="ewd-otp-dashboard-banner-icon"></div>
				<div class="ewd-otp-dashboard-banner-buttons">
					<a class="ewd-otp-dashboard-new-upgrade-button" href="http://www.etoilewebdesign.com/plugins/order-tracking/#buy" target="_blank">UPGRADE NOW</a>
				</div>
				<div class="ewd-otp-dashboard-banner-text">
					<div class="ewd-otp-dashboard-banner-title">
						GET FULL ACCESS WITH OUR PREMIUM VERSION
					</div>
					<div class="ewd-otp-dashboard-banner-brief">
						Track the status of your order simply and effectively
					</div>
				</div>
			</div>
		<?php } ?>