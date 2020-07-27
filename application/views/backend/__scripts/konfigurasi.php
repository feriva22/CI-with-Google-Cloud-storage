<script type="text/javascript">
$(document).ready(function() {
    /*
    page_click('#reset_database',function(e){
        // confirmation
        $.confirm({
            title: 'Reset Database',
            content: 'Mereset Database akan menghapus seluruh nilai pada database',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Saya Paham',
                    btnClass: 'btn-blue',
                    action: function(){
                        $.confirm({
                            title: 'Data Akan Terhapus',
                            content: 'Data yang Terhapus tidak dapat dikembalikan lagi',
                            icon: 'fa fa-warning',
                            animation: 'scale',
                            closeAnimation: 'zoom',
                            buttons: {
                                confirm: {
                                    text: 'Iya, Lanjutkan!',
                                    btnClass: 'btn-danger',
                                    action: function(){
                                        ajaxExtend({
                                            url: base_url+'backend/konfigurasi/reset_db',
                                            data:{},
                                            success: function(data){
                                                $.alert(data.message);
                                            },
                                            error: function(jxHr){
                                                $.alert('Terjadi Kesalahan !');
                                            }
                                        })                  
                                    }
                                },
                                batal: function(){}
                            }
                        });
                    }
                },
                cancel: function(){}
            }
        });
    })
    */


    $('#config-form').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        formData.append(csrf_name,Cookies.get(csrf_name));//append csrf
        $.ajax({
            url: base_url+'backend/konfigurasi/save',
            data: formData,
            type: 'post',
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: (resp)=>{
                if(isJson(resp)) {resp = JSON.parse(resp);}
                if(typeof(resp.status) !== 'undefined') {show_notification(resp.status,resp.message);}
                else {show_notification('error','Anda tidak memiliki akses');}
            },
            error: ()=>{
                show_notification('error','Error Connecting Server');
            }
        })
    })
    
})
</script>