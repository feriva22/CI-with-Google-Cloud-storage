<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var url = {
        data : base_url+'backend/document/get_datatable',
        detail : base_url+'backend/document/detail',
        add: base_url + 'backend/document/add',
		edit: base_url + 'backend/document/edit',
		delete: base_url + 'backend/document/delete',
    };

    var dataTableObj = $("#document_table").DataTable({
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
            {   data:"doc_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="doc_id[]" value="'+ data +'"/>';
                }
            },
            { 
                data:"doc_id",
                render: function(data, type, meta){
                    return `<div class="table-actions">
                    <button class="edit_act update_role btn btn-success btn-icon"><i class="ik ik-edit-2"></i></button>
                                    <button class="delete_act delete_role btn btn-danger btn-icon"><i class="ik ik-trash-2"></i></button>
                            </div>`
                }
            },
            { data:"doc_name" , visible: true},
            { data:"doc_desc" , visible: true},
            { data:"doc_file" , visible: true,
                render: function(data,type,meta){
                    
                    return (data !== null && data !== "") ? `<a href="${data}" class="btn btn-success btn-sm"> Download</a>` : 'Failed';
                }
            },
            { data:"doc_status" ,
                render:function(data,type,meta){
                    return (data == <?php echo PUBLISH;?>) ? 'Publish' : 'Draft';
                }
            }
        ],
		"order": [],
			searchDelay: 500,
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.doc_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add',null,null,true);
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('doc_id',e),true);
    });

    page_click('.delete_act',(e)=>{
        deleteData_handler(url,get_row_dataid('doc_id',e,true),dataTableObj);
    });

    page_click('#multidel_act',(e)=>{
        var row_selected = get_checked_row('doc_id');
        if(row_selected['doc_id'].length != 0){
            deleteData_handler(url,row_selected,dataTableObj);
        }else{
            show_notification('warning','Pilih data !');
        }
    });

    formPhoto_handler('doc_file');


    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj);
});
</script>