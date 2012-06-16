<div id="title">HDD Monitoring</div>

<div id="linkGroup">
    <div class="link"><a href="view_hdd_status_now">HDD Status</a></div>
    <div class="link"><a href="edit_person_info">Account</a></div>
    <div class="link"><a href="show_hdd_info">HDD settings</a></div>
    <div class="link"><a href="logout">logout</a></div>
</div>

<div id="blueBox"> 
  <div id="header"></div>
  <div class="contentTitle">Welcome to HDD Monitoring</div>
    <div class="pageContent">
	<div id="edit-person-info">
	<?php
		echo "Edit Your Account : ".$this->session->userdata('username');
		$user = $user[0];
	    ?>
	    
	    
	    <h3>Edit User</h3>
	    <?php echo form_open('site/edit_account');?>
	    <input type="hidden" name="id_user" id="id_user" value="<?php echo $user->id_user; ?>"/>

	    <label for="konten1">Nama : </label>
	    <input type="text" name="name" id="name" value="<?php echo $user->name; ?>"/>
	    <br/>
	    <label for="konten1">Username : </label>
	    <input type="text" name="username" id="username" value="<?php echo $user->username; ?>" readonly="readonly" />
	    <br/>
	    <label for="konten1">New Username : </label>
	    <input type="text" name="new_username" id="new_username" value=""/>
	    <br/>
	    <label for="konten1">Password : </label>
	    <input type="text" name="password" id="password" value="<?php echo $user->password; ?>" readonly="readonly" />
	    <br/>
	    <label for="konten1">New Password : </label>
	    <input type="text" name="new_password" id="new_password" value=""/>
	    <br/>
	    <label for="konten1">Email : </label>
	    <input type="text" name="email" id="email" value="<?php echo $user->email; ?>"/>
	    <br/>
	 
	    <label for="submit"><input type="submit" value="Update Now"/></label>

	    <?php form_close();?>

	    <br/><br/>
	    <a href="show_hdd_info">HDD settings</a><br/>
	    <a href="admin">Back to home</a>
	    
	</div>
</div>
