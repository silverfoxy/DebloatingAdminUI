<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Import Coverage Information</h3>
            </div>
            <?php echo form_open_multipart('import_coverage/import'); ?>
          	<div class="box-body">
			  	<div class="col-md-4">
					<label for="fk_version_id" class="control-label">Software Version</label>
					<div class="form-group">
						<select name="fk_version_id" id="fk_software" class="form-control" required>
							<option value="">select Software Version</option>
							<?php
							foreach($all_software_version as $software_version)
							{
								$selected = ($software_version['id'] == $this->input->post('fk_version_id')) ? ' selected="selected"' : "";
								echo '<option software_id="'.$software_version['fk_software_id'].'" value="'.$software_version['id'].'" '.$selected.'>'.$software_version['name'].' '.$software_version['version'].'</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<label for="original_path_prefix" class="control-label">Original Path Prefix</label>
					<div class="form-group">
						<input type="text" name="original_path_prefix" value="<?php echo $this->input->post('original_path_prefix'); ?>" class="form-control" id="original_path_prefix" placeholder="/mnt/c/Users/username/Documents/webapps/" />
					</div>
				</div>
				<div class="col-md-4">
					<label for="new_path_prefix" class="control-label">New Path Prefix</label>
					<div class="form-group">
						<input type="text" name="new_path_prefix" value="<?php echo $this->input->post('new_path_prefix'); ?>" class="form-control" id="new_path_prefix" placeholder="/var/www/html/" />
					</div>
				</div>
				<div class="col-md-4">
					<label for="test_name" class="control-label">Test Name</label>
					<div class="form-group">
						<input type="text" name="test_name" value="<?php echo $this->input->post('test_name'); ?>" class="form-control" id="test_name" placeholder="Magento_import" />
					</div>
				</div>
				<div class="col-md-8">
					<label for="filename" class="control-label">File</label>
					<div class="form-group">
						<input type="file" name="file" accept=".txt" required />
				</div>
			</div>
			<div class="col-md-12">
			<div class="box-footer">
            	<button type="submit" class="btn btn-success">
            		<i class="fa fa-check"></i> Submit
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>
