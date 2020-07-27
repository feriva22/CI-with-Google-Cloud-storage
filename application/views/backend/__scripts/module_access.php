<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var url = {
        data : base_url+'backend/module_access/get_datatable',
        detail : base_url+'backend/module_access/detail',
        add: base_url + 'backend/module_access/add',
		edit: base_url + 'backend/module_access/edit',
		delete: base_url + 'backend/module_access/delete',
    };

    var dataTableObj = $("#module_access_table").DataTable({
        processing:true,
        serverSide:true,
        pagingType: 'full_numbers',
        ajax:{
            url: url.data,
            type: 'POST',
            dataType: "json",
            data: (dataReq)=>{ dataReq[csrf_name] = Cookies.get(csrf_name);return dataReq;}, 
        },
        'columns':[ 
            {   data:"mda_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="mda_id[]" value="'+ data +'"/>';
                }
            },
            { 
                data:"mda_id",
                render: function(data, type, meta){
                    return `<div class="table-actions">
                    <button class="edit_act update_role btn btn-success btn-icon"><i class="ik ik-edit-2"></i></button>
                                    <button class="delete_act delete_role btn btn-danger btn-icon"><i class="ik ik-trash-2"></i></button>
                            </div>`
                }
            },
            { data:"mda_module" , visible: true},
            { data:"mda_staffgroup" , visible: true},
            { data:"mda_create" , visible: true,
                render:function(data,type,meta){
                    return (data == <?php echo GRANTED;?>) ? 'Granted' : 'Ungranted';
                }
            },
            { data:"mda_read" , visible: true,
                render:function(data,type,meta){
                    return (data == <?php echo GRANTED;?>) ? 'Granted' : 'Ungranted';
                }
            },
            { data:"mda_update" , visible: true,
                render:function(data,type,meta){
                    return (data == <?php echo GRANTED;?>) ? 'Granted' : 'Ungranted';
                }
            },
            { data:"mda_delete" , visible: true,
                render:function(data,type,meta){
                    return (data == <?php echo GRANTED;?>) ? 'Granted' : 'Ungranted';
                }
            }
        ],
		"order": [],
			searchDelay: 500,
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.mda_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add',null,null,true);
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('mda_id',e),true);
    });

    page_click('.delete_act',(e)=>{
        deleteData_handler(url,get_row_dataid('mda_id',e,true),dataTableObj);
    });

    page_click('#multidel_act',(e)=>{
        var row_selected = get_checked_row('mda_id');
        if(row_selected['mda_id'].length != 0){
            deleteData_handler(url,row_selected,dataTableObj);
        }else{
            show_notification('warning','Pilih data !');
        }
    });

    page_click('#check_all',(e)=>{
        is_check = $('#check_all').is(':checked');
        $('#mda_create').prop('checked', is_check);
        $('#mda_read').prop('checked', is_check);
        $('#mda_update').prop('checked', is_check);
        $('#mda_delete').prop('checked', is_check);
    })

    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj,(formObj) => {
        /*
        data_group_access = {};
        access = {"create" : "mda_create","read" : "mda_read","update" : "mda_update","delete" : "mda_delete"};

        $('#mdm_staffgroupacc').find("option:selected").each(function(){
            group_id = $(this).parent().data("id");
            permission = $(this).val();
            if(data_group_access.hasOwnProperty(group_id)){
                if(access.hasOwnProperty(permission)){
                    data_group_access[group_id][access[permission]] =  'on';
                }
            }else{
                if(access.hasOwnProperty(permission)){
                    data_group_access[group_id] = { [access[permission]] : 'on'};
                }            }
            //console.log();
        });
        console.log(data_group_access);
        //console.log($('#mdm_staffgroupacc').val());
        formObj.append('mdm_staffgroupacc',JSON.stringify(data_group_access));
        */
    });
});
</script>