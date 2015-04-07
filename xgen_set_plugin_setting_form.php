<div class="width_100">
	<h3>xGen Plugin Date Information Plus</h3>
	<?php
		if (isset($message)) {
			$message_output = htmlspecialchars(strip_tags(esc_sql($message)));
			echo "<div style='color:green;font-size:14px;'>".$message_output."</div>";
		}
	?>
	<div>&nbsp;</div>
	<form action='?page=xgen_plugin_date_information' method='POST'>
		<h2>Select the columns to display on your plugins page</h2>
		<div class="width_100">
			<div class="width_20 fl">Install Date:</div>
			<div class="width_80 fl">
				<?php
					$yes=$no='';
					$install_date_value	= get_option('install_date_value');
					if ($install_date_value == 'yes') {
						$yes	= "selected='selected'";
						$no		= "";
					} elseif ($install_date_value == 'no') {
						$yes	= "";
						$no		= "selected='selected'";
					}
				?>
				<select id='install_date_value' name='install_date_value' class="custom_select_tag">
					<option value='yes' <?=$yes?>>Yes</option>
					<option value='no' <?=$no?>>No</option>
				</select>
			</div>

			<div class="width_20 fl">Activated Date:</div>
			<div class="width_80 fl">
	    		<?php
					$yes=$no='';
					$activated_date_value	= get_option('activated_date_value');
					if ($activated_date_value == 'yes') {
						$yes	= "selected='selected'";
						$no		= "";
					} elseif ($activated_date_value == 'no') {
						$yes	= "";
						$no		= "selected='selected'";
					}
				?>
				<select id='activated_date_value' name='activated_date_value' class="custom_select_tag">
					<option value='yes' <?=$yes?>>Yes</option>
					<option value='no' <?=$no?>>No</option>
				</select>
			</div>

			<div class="width_20 fl">Deactivated Date:</div>
			<div class="width_80 fl">
	    		<?php
					$yes=$no='';
					$deactivated_date_value	= get_option('deactivated_date_value');
					if ($deactivated_date_value == 'yes') {
						$yes	= "selected='selected'";
						$no		= "";
					} elseif ($deactivated_date_value == 'no') {
						$yes	= "";
						$no		= "selected='selected'";
					}
				?>
				<select id='deactivated_date_value' name='deactivated_date_value' class="custom_select_tag">
					<option value='yes' <?=$yes?>>Yes</option>
					<option value='no' <?=$no?>>No</option>
				</select>
			</div>

			<div class="width_20 fl">Latest Update Information in it's Description:</div>
			<div class="width_80 fl">
	    		<?php
					$yes=$no='';
					$updated_date_value	= get_option('updated_date_value');
					if ($updated_date_value == 'yes') {
						$yes	= "selected='selected'";
						$no		= "";
					} elseif ($updated_date_value == 'no') {
						$yes	= "";
						$no		= "selected='selected'";
					}
				?>
				<select id='updated_date_value' name='updated_date_value' class="custom_select_tag">
					<option value='yes' <?=$yes?>>Yes</option>
					<option value='no' <?=$no?>>No</option>
				</select>
			</div>
		</div>

		<div>&nbsp;</div>

		<div class="width_100 sepbar">
			<h2>Enter the desired column name</h2>
			<div class="width_20 fl">Install Date:</div>
			<div class="width_80 fl">
				<input type='text' value="<?php echo get_option('install_column_text'); ?>" id='install_column_text' name='install_column_text' class="custom_textbox"/>
			</div>

			<div class="width_20 fl">Activated Date:</div>
			<div class="width_80 fl">
				<input type='text' value="<?=get_option('activated_column_text');?>" id='activated_column_text' name='activated_column_text' class="custom_textbox" />
			</div>

			<div class="width_20 fl">Deactivated Date:</div>
			<div class="width_80 fl">
				<input type='text' value="<?=get_option('deactivated_column_text');?>" id='deactivated_column_text' name='deactivated_column_text' class="custom_textbox" />
			</div>

			<div class="width_20 fl">Latest Update Plugin Date:</div>
			<div class="width_80 fl">
				<input type='text' value="<?=get_option('update_column_text');?>" id='update_column_text' name='update_column_text' class="custom_textbox" />
			</div>
		</div>

		<div>&nbsp;</div>

		<div class="width_100 sepbar">
			<h2>Enter your preferred Timestamp formats</h2>
			<p>
				<strong>Tip:</strong> Leave any field blank to use the default setting from your WordPress installation.
				Refer to <a href="http://php.net/manual/en/function.date.php" title="Time / Date Formatting" target="_blank">this page</a> for choices.
			</p>
			<div class="width_20 fl">Shown in columns (date):</div>
			<div class="width_80 fl">
				<input type='text' value="<?php echo get_option('timestamp_format_columns_date'); ?>" id='timestamp_format_columns_date' name='timestamp_format_columns_date' class="custom_textbox"/>
			</div>

			<div class="width_20 fl">Shown in columns (time:)</div>
			<div class="width_80 fl">
				<input type='text' value="<?php echo get_option('timestamp_format_columns_time'); ?>" id='timestamp_format_columns_time' name='timestamp_format_columns_time' class="custom_textbox"/>
			</div>

			<div class="width_20 fl">Shown in description:</div>
			<div class="width_80 fl">
				<input type='text' value="<?php echo get_option('timestamp_format_desc'); ?>" id='timestamp_format_desc' name='timestamp_format_desc' class="custom_textbox"/>
			</div>
		</div>

		<div>&nbsp;</div>

		<div class="width_100 sepbar">
			<h2>Compact View</h2>
			<p>You can enable Compact View to tidy up the info shown under the plugin descriptions. This keeps all the same info but formats it "neater."</p>
			<div class="width_20 fl">Enabled:</div>
				<div class="width_80 fl">
					<input type="checkbox" value="1" <?php checked( '1', get_option( 'xgenpc_compact_view' ) ); ?> name="xgenpc_compact_view" />
				</div>
		</div>

		<div>&nbsp;</div>

		<div>
			<input type="submit" value="Save Settings" name="xgen_pdi_submit" id="xgen_pdi_submit" class="button-primary"/>
		</div>
	</form>
</div>