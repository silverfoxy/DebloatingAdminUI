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
                <?php foreach($phploc_files as $p){ ?>
                <table class="table table-striped">
                    <?php echo "Name of Software :".$p['software_name']."<br>"; 
                         echo "The Description : ".$p['description'];
                        $data = unserialize($p['data_details']); 
                        $totalsize = unserialize($p['size']);
                        $percentage = unserialize($p['percentage']);
                   ?>
                    <tr>
						<th>Data</th>
                        <th>Size</th>
                        <th>Percentage</th>
                    </tr>
                        <?php
                        for($i = 0; $i< count($data);$i++){
                            echo '<tr>';
                            echo '<td>'.$data[$i].'</td>';
                            echo '<td>'.$totalsize[$i].'</td>';
                            echo '<td>'.$percentage[$i].'</td>';
                            echo ' </tr>';
                        }
                        ?>
                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
</div>
