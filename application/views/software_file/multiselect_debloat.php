<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Test Groups Listing: <?php echo count($tests) ?> items</h3>
                <div class="box-tools">
<!--                    <a disabled href="#" onclick="return confirm('Are you sure you want to delete all the data related to tests?')" class="btn btn-danger btn-sm">Remove All</a>-->
<!--                    <a disabled href="#" class="btn btn-success btn-sm">Add</a>-->
<!--                    <a disabled id="diff_coverage" href="#" class="btn btn-info btn-sm">Diff Coverage</a>-->
<!--                    <div class="btn-group" role="group" aria-label="Action button group">-->
<!--                        <button id="output_html" class="btn btn-success btn-sm">HTML</button>-->
<!--                        <button id="output_csv" class="btn btn-sm">CSV</button>-->
<!--                    </div>-->
                    <div class="btn-group" role="group" aria-label="Action button group">
                        <a href="#" style="cursor: default; background-color:#3c8dbc !important; border-color:#367fa9 !important;" class="btn btn-primary btn-sm">Multi Select</a>
                        <a disabled id="debloat_files" href="#" class="btn btn-danger btn-sm"><span class="fa fa-refresh"></span> Debloat Files</a>
                        <a disabled id="debloat_functions" href="#" class="btn btn-danger btn-sm"><span class="fa fa-file-code-o"></span> Debloat Functions</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Test Group</th>
                        <th style="width: 90px">Multi Select</th>
                    </tr>
                    <?php $row_num = 1; ?>
                    <?php foreach($tests as $t){ ?>
                        <tr>
                            <td><a href="<?php echo site_url('test/groups/'.$t['test_group']); ?>"><?php echo $row_num; $row_num++; ?></a></td>
                            <td><a href="<?php echo site_url('test/groups/'.$t['test_group']); ?>"><?php echo $t['test_group']; ?></a></td>
                            <td style="text-align: center;">
                                <input type="checkbox" id="<?php echo "chk_".$t['test_group']; ?>" value="<?php echo $t['test_group']; ?>" name="multiselect_chk" />
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="multiselect_chk"]').change(function() {
            checked_items = [];
            $('input[name="multiselect_chk"]').each(function(){
                if($(this).is(":checked")) {
                    checked_items.push($(this).val());
                }
            });
            if (checked_items.length <= 0) {
                $('#debloat_files').attr('disabled', 'disabled');
                $('#debloat_functions').attr('disabled', 'disabled');
            }
            else {
                $('#debloat_files').removeAttr("disabled");
                $('#debloat_functions').removeAttr("disabled");
                update_union_hrefs(checked_items.length);
            }
        });
        function update_union_hrefs($checked_items_length)
        {
            page_url = window.location.href;
            software_version_id = page_url.substring(page_url.lastIndexOf('/') + 1);
            base_href = '<?php echo site_url("software_file/multiselect_debloat_files/"); ?>';
            $('#debloat_files').attr('href', base_href + software_version_id + '/' + checked_items.join('/'));
            base_href = '<?php echo site_url("software_file/multiselect_debloat_functions/"); ?>';
            $('#debloat_functions').attr('href', base_href + software_version_id + '/' + checked_items.join('/'));
        }
    });
</script>
