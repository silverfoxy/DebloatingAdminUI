<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Choose Software Version</h3>
            </div>
            <?php echo form_open('builtin_function/add'); ?>
          	<div class="box-body">
          		<div class="row clearfix">
					<div class="col-md-6">
						<label for="fk_version_id" class="control-label">Software Version</label>
						<div class="form-group">
							<select name="fk_version_id" id="fk_software" class="form-control">
								<option value="">Select Software Version</option>
								<?php	
								foreach($software_versions as $software_version)
								{
									$selected = ($software_version['id'] == $this->input->post('fk_version_id')) ? ' selected="selected"' : "";

									echo '<option software_id="'.$software_version['fk_software_id'].'" value="'.$software_version['id'].'" '.$selected.'>'.$software_version['name'].' '.$software_version['version'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
				<div class="col-md-6">
						<label for="Description" class="control-label">Description</label>
						<div class="form-group">
							<input type="text" name="description" value="<?php echo $this->input->post('description'); ?>" class="form-control" id="description" />
						</div>
					</div>
				</div>
			</div>
			
          	<div class="box-footer">
            	<button type="submit" class="btn btn-success">
            		<i class="fa fa-check"></i> Save
            	</button>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>
	