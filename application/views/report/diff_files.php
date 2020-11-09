<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Diff (<span style="background-color: #f0a0a0">Light Red</span>:<em>"<?php echo $test_group[0];?>"</em> and <span style="background-color: #ffc">Light Yellow</span>: <em>"<?php echo $test_group[1];?>"</em>):
                </h3>
                <br />
                <span style="background-color: #b0f0a0">Light Green</span> highlighted lines indicate lines covered by both of the test groups.
            </div>
            <div class="box-body">
                <b><?php echo $file_path; ?></b>
                <?php echo $php_code; ?>
            </div>
        </div>
    </div>
</div>