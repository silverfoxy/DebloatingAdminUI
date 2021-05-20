<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Builtin Files Listing: </b></h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('builtin_function/add'); ?>" class="btn btn-success btn-sm">Add</a>
                </div>
            </div>
            <div class="box-body">
                <?php foreach($builtin_files as $p){ ?>
                <table class="table table-striped">
                    <?php echo "Name of Software :".$p['software_name']."<br>"; 
                         echo "The Description : ".$p['description'];
                         $total = $p['total'];
                         $command_execution = $p['command_execution'];
                         $code_execution = $p['code_execution'];
                         $callbacks = $p['callbacks'];
                         $information_disclosure = $p['information_disclosure'];
                   ?>
                    <tr>
						<th>Total Files</th>
                        <th>Command_Execution</th>
                        <th>Code Execution</th>
                        <th> Call backs</th>
                        <th>Information Disclosure</th>
                    </tr>
                        <?php
                            echo '<tr>';
                            echo '<td>'.$total.'</td>';
                            echo '<td>'.$command_execution.'</td>';
                            echo '<td>'.$code_execution.'</td>';
                            echo '<td>'.$callbacks.'</td>';
                            echo '<td>'.$information_disclosure.'</td>';

                            echo ' </tr>';
                        
                        ?>
                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
</div>
