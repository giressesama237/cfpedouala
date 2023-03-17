
            <a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_teacher_add/');?>');"
                class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('add_new_teacher');?>
                </a>
                <a href="<?php echo site_url('admin/print_teacher_list')?>" 
                class="btn btn-primary pull-right">
                <i class="entypo-plus-printer"></i>
                <?php echo get_phrase('print');?>
                </a>
                <br><br>
               <table class="table table-bordered datatable" id="teachers">
                    <thead>
                        <tr>
                            <th width="60"><div><?php echo get_phrase('id');?></div></th>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('surname');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email').'/'.get_phrase('username');?></div></th>
                            <th><div><?php echo get_phrase('higher_diploma');?></div></th>
                            <th><div><?php echo get_phrase('speciality');?></div></th>
                            <th><div><?php echo get_phrase('statut');?></div></th>
                            <th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                </table>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#teachers').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "<?php echo site_url('admin/get_teachers') ?>",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                { "data": "teacher_id" },
                { "data": "photo" },
                { "data": "surname" },
                { "data": "name" },
                { "data": "email" },
                { "data": "higher_diploma" },
                { "data": "speciality" },
                { "data": "statut" },
                { "data": "phone" },
                { "data": "options" },
            ],
            "columnDefs": [
                {
                    "targets": [1,5],
                    "orderable": false
                },
            ]
        });
    });

    function teacher_edit_modal(teacher_id) {
        showAjaxModal('<?php echo site_url('modal/popup/modal_teacher_edit/');?>' + teacher_id);
    }
    function teacher_print_id_modal(teacher_id) {
        showAjaxModal('<?php echo site_url('modal/popup/modal_teacher_id_card/');?>' + teacher_id);
    }

    function teacher_delete_confirm(teacher_id) {
        confirm_modal('<?php echo site_url('admin/teacher/delete/');?>' + teacher_id);
    }

</script>
