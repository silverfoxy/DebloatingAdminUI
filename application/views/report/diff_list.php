<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Mismatched files:
                  <?php echo $mismatch ?>
                </h3>
                &nbsp;
                <i id="swap_diff_order" class="fa fa-exchange" style="color: #00c0ef; cursor: pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Swap the order of files"></i>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
						<th>ID</th>
                        <?php foreach($test_groups as $test_group) { echo "<th>".$test_group."</th>"; } ?>
                        <th>Software</th>
                        <th>Version</th>
                        <th>File Name</th>
                        <th>Matching Lines</th>
                        <th>Unmatched Lines</th>
                    </tr>
                    <?php $counter = 1; ?>
                <?php foreach($software_files as $sw_file){ ?>
                    <tr>
                        <?php
                        $file_ids = $sw_file['id'];
                        if (sizeof($sw_file['test_group_coverage']) < 2) {
                            if ($test_groups[0] === $sw_file['test_group_coverage'][0]) {
                                $file_ids[1] = -1;
                            }
                            else {
                                $file_ids[1] = $file_ids[0];
                                $file_ids[0] = -1;
                            }
                        }
                        ?>
                        <td><a href="<?php echo site_url('report/diff_files/'.implode('/', $file_ids).'/'.implode('/', $test_ids)) ?>"><?php echo $counter; $counter++; ?></a></td>
                        <?php
                          foreach($test_groups as $test_group) {
                              if (in_array($test_group, $sw_file['test_group_coverage'])) {
                                  echo "<td><a href=\"".site_url('report/diff_files/'.implode('/', $file_ids)."/".implode('/', $test_ids))."\"><i style='color: green' class='fa fa-check' /></a></td>";
                              }
                              else {
                                  echo "<td><a href=\"".site_url('report/diff_files/'.implode('/', $file_ids)."/".implode('/', $test_ids))."\"><i style='color: red' class='fa fa-close' /></a></td>";
                              }
                          } ?>
                        <td><a href="<?php echo site_url('report/diff_files/'.implode('/', $file_ids).'/'.implode('/', $test_ids)) ?>"><?php echo $sw_file['software']; ?></a></td>
                        <td><a href="<?php echo site_url('report/diff_files/'.implode('/', $file_ids).'/'.implode('/', $test_ids)) ?>"><?php echo $sw_file['version']; ?></a></td>
                        <td><a href="<?php echo site_url('report/diff_files/'.implode('/', $file_ids).'/'.implode('/', $test_ids)) ?>"><?php echo $sw_file['file_name']; ?></a></td>
                        <td><a href="<?php echo site_url('report/diff_files/'.implode('/', $file_ids).'/'.implode('/', $test_ids)) ?>"><?php echo $sw_file['matched_coverage']; ?></a></td>
                        <td><a href="<?php echo site_url('report/diff_files/'.implode('/', $file_ids).'/'.implode('/', $test_ids)) ?>"><?php echo $sw_file['unmatched_coverage']; ?></a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
        $('#swap_diff_order').on('click', function(e) {
            var page_url_parts = window.location.href.split('/');
            var test_group_1 = page_url_parts[page_url_parts.length - 1];
            var test_group_2 = page_url_parts[page_url_parts.length - 2];
            console.log(test_group_1);
            console.log(test_group_2);
            page_url_parts[page_url_parts.length - 2] = test_group_1;
            page_url_parts[page_url_parts.length - 1] = test_group_2;
            var swapped_url = page_url_parts.join('/');
            window.location.href = swapped_url;
            return true;
        });
</script>