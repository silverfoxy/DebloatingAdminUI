<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Phploc Files Listing: </b></h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('phploc/add'); ?>" class="btn btn-success btn-sm">Add</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
						<th>ID</th>
                        <th>Software Name</th>
                        <th>Version </th>
                        <th>Description</th>
                    </tr>
                        <?php
                            foreach($phploc_files as $p){
                            $id = $p['ID'];
                            echo '<tr>';
                            echo "<td><a href='seperate_listing/$id'>".$p['ID']."</td></a>";
                            echo "<td><a href='seperate_listing/$id'>".$p['software_name']."</td></a>";
                            echo "<td>".$p['version']."</td>";
                            echo "<td>".$p['description']."</td></a>";
                            echo ' </tr>';
                            }
                        ?>
                </table>

            </div>
        </div>
    </div>
</div>
