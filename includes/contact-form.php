<form id="contact-form" class="form" action="<?php echo $form['action']; ?>" method="<?php echo $form['method']; ?>" onsubmit="removeEmptyInput()">
	<!--Left side-->
	<div class="formContainer">
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Artist/Band Name</span>
				</div>
				<div class="floatRight">
					<input type="text" name="band" id="band" value="<?php echo $form['band']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>/>
				</div>
			</label>
		</div>
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">First Name</span>
				</div>
				<div class="floatRight">
					<input type="text" name="first_name" id="first_name" value="<?php echo $form['first_name']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>/>
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">	
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Last Name</span>
				</div>
				<div class="floatRight">
					<input type="text" name="last_name" id="last_name" value="<?php echo $form['last_name']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?> />
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">	
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Email Address</span>
				</div>
				<div class="floatRight">
					<input type="text" name="email" id="email" value="<?php echo $form['email']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>>
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">	
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Phone Number</span>
				</div>
				<div class="floatRight">
					<input type="tel" name="phone" id="phone" value="<?php echo $form['phone']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>>
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">	
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Mobile Number</span>
				</div>
				<div class="floatRight">
					<input type="tel" name="mobile" id="mobile" value="<?php echo $form['mobile']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>>
				</div>
			</label>
		</div>
		<div class="clear"></div>
	</div>
	
	<!--Right side-->
	<div class="formContainer">
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Company</span>
				</div>
				<div class="floatRight">
					<input type="text" name="company" id="company" value="<?php echo $form['company']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>/>
				</div>
			</label>
		</div>
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Address Line 1</span>
				</div>
				<div class="floatRight">
					<input type="text" name="add_line_1" id="add_line_1" value="<?php echo $form['add_line_1']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>/>
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Address Line 2</span>
				</div>
				<div class="floatRight">
					<input type="text" name="add_line_2" id="add_line_2" value="<?php echo $form['add_line_2']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>/>
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">City/Town</span>
				</div>
				<div class="floatRight">
					<input type="text" name="city" id="city" value="<?php echo $form['city']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>/>
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">State</span>
				</div>
				<div class="floatRight">
					<?php 
						if ($form['show_state']) {
							$states = array('', 'ACT', 'NSW', 'NT', 'QLD', 'SA', 'TAS', 'VIC', 'WA');
					?>
					<select name="state" id="state">
							<?php 
							foreach ($states as $state) {
								echo '<option value="' . $state .'"'. ($form['state'] == $state ?   'selected="selected"' : '' ) . ' >' . $state . '</option>';
							}
							?>
					</select>
					<?php
						} else {
					?>
					<input type="text" name="state" id="state" value="<?php echo $form['state']; ?>" readonly />
					<?php
						}
					?>
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Post Code</span>
				</div>
				<div class="floatRight">
					<input type="text" name="post_code" id="post_code" value="<?php echo $form['post_code']; ?>" autocomplete="off" <?php echo ($form['read_only'] ? 'readonly' : ''); ?>/>
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
	
	</div>
	<?php
	if ($form['show_notes']) {
	?>
	
	<!--Hidden Inputs-->
	<input type="hidden" name="id" id="id" value ="<?php echo $form['id']; ?>" />
	
	<label for="notes" class="ta-label">Notes</label>
	<div class="ta-div">
		<textarea name="notes" id="notes" class="ta-notes" <?php echo ($form['read_only'] ? 'readonly' : ''); ?> ><?php echo $form['notes']; ?></textarea>
	</div>
	<?php
	}
	if ($form['show_button']) {
	?>
	<div class="button-padding" >
		<div class="field-submit">	
			<input type="submit" value="<?php echo $form['button']; ?>">
		</div>
	</div>
	<?php
	}
	?>
</form>